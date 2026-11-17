<?php

namespace App\Plugins\RackBuilder\Http\Controllers;

use App\Models\Device;
use App\Plugins\RackBuilder\Models\Node;
use App\Plugins\RackBuilder\Models\Rack;
use App\Plugins\RackBuilder\Models\Server;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class RackBuilderController extends Controller
{
    /** Number of U slots on each telecom side panel. */
    private const SIDE_PANEL_SIZE = 6;

    /** Uptime (seconds) under which a device is flagged as "recently rebooted". */
    private const RECENT_REBOOT_SECONDS = 86400;

    private const DEVICE_COLUMNS = ['device_id', 'hostname', 'display', 'sysName', 'status', 'disabled', 'ignore', 'uptime'];

    // ------------------------------------------------------------------
    // Racks
    // ------------------------------------------------------------------

    public function listRacks(): JsonResponse
    {
        return response()->json(
            Rack::withCount('servers')->orderBy('name')->get()
        );
    }

    public function createRack(Request $request): JsonResponse
    {
        $rack = Rack::create($this->validateRack($request));

        return response()->json($rack, 201);
    }

    public function updateRack(Request $request, $rack): JsonResponse
    {
        $rack = Rack::findOrFail($rack);
        $data = $this->validateRack($request);

        // Shrinking a rack must not orphan servers above the new top U.
        if ($data['size'] < $rack->size) {
            $tooHigh = $rack->servers()
                ->where('panel', 'main')
                ->whereRaw('u_position + u_height - 1 > ?', [$data['size']])
                ->exists();
            if ($tooHigh) {
                return $this->error('Servers are mounted above U' . $data['size'] . '; move them before shrinking the rack');
            }
        }

        $rack->update($data);

        return response()->json($rack);
    }

    public function deleteRack($rack): JsonResponse
    {
        $rack = Rack::findOrFail($rack);

        DB::transaction(function () use ($rack) {
            $serverIds = $rack->servers()->pluck('id');
            Node::whereIn('server_id', $serverIds)->delete();
            Server::whereIn('id', $serverIds)->delete();
            $rack->delete();
        });

        return response()->json(['message' => 'Rack deleted']);
    }

    public function getServers($rack): JsonResponse
    {
        $rack = Rack::findOrFail($rack);

        $servers = $rack->servers()
            ->with(['nodes.device' => fn ($q) => $q->select(self::DEVICE_COLUMNS)])
            ->orderBy('u_position')
            ->get();

        return response()->json([
            'rack' => $rack->only(['id', 'name', 'size', 'layout', 'description']),
            'servers' => $servers->map(function (Server $server) {
                $data = $server->toArray();
                $data['nodes'] = $server->nodes->map(fn (Node $node) => $this->presentNode($node))->values();

                return $data;
            })->values(),
        ]);
    }

    public function getStatus($rack): JsonResponse
    {
        $rack = Rack::findOrFail($rack);

        $nodes = Node::query()
            ->whereIn('server_id', $rack->servers()->select('id'))
            ->with(['device' => fn ($q) => $q->select(self::DEVICE_COLUMNS)])
            ->get();

        $statuses = [];
        foreach ($nodes as $node) {
            $device = $node->device;
            $statuses[$node->id] = [
                'device_id' => $node->device_id,
                'status' => $device ? (int) $device->status : null,
                'uptime' => $device ? (int) $device->uptime : null,
                'status_light' => $this->getStatusLight($device),
            ];
        }

        return response()->json((object) $statuses);
    }

    // ------------------------------------------------------------------
    // Servers
    // ------------------------------------------------------------------

    public function createServer(Request $request): JsonResponse
    {
        $data = $this->validateServer($request, true);
        $rack = Rack::findOrFail($data['rack_id']);

        if ($error = $this->checkPlacement($rack, $data, null)) {
            return $this->error($error);
        }

        $server = DB::transaction(function () use ($data) {
            $server = Server::create($data);
            for ($i = 1; $i <= $data['num_nodes']; $i++) {
                $server->nodes()->create([
                    'node_number' => $i,
                    'label' => $data['num_nodes'] === 1 ? $data['name'] : 'Node ' . $i,
                ]);
            }

            return $server;
        });

        return response()->json($server->load('nodes'), 201);
    }

    public function updateServer(Request $request, $server): JsonResponse
    {
        $server = Server::findOrFail($server);
        $data = $this->validateServer($request, false);
        $rack = Rack::findOrFail($server->rack_id);

        if ($error = $this->checkPlacement($rack, $data, $server->id)) {
            return $this->error($error);
        }

        DB::transaction(function () use ($server, $data) {
            $server->update($data);
            $this->syncServerNodes($server, $data['num_nodes']);
        });

        return response()->json($server->load('nodes'));
    }

    public function deleteServer($server): JsonResponse
    {
        $server = Server::findOrFail($server);

        DB::transaction(function () use ($server) {
            $server->nodes()->delete();
            $server->delete();
        });

        return response()->json(['message' => 'Server deleted']);
    }

    // ------------------------------------------------------------------
    // Nodes
    // ------------------------------------------------------------------

    public function createNode(Request $request): JsonResponse
    {
        $data = $request->validate([
            'server_id' => 'required|integer|exists:rack_builder_servers,id',
            'node_number' => 'required|integer|min:1|max:4',
            'label' => 'required|string|max:255',
            'device_id' => 'nullable|integer|exists:devices,device_id',
            'description' => 'nullable|string|max:65535',
        ]);

        $exists = Node::where('server_id', $data['server_id'])
            ->where('node_number', $data['node_number'])
            ->exists();

        if ($exists) {
            return $this->error('Node number already exists for this server');
        }

        $node = Node::create($data);

        return response()->json($this->presentNode($node->load('device')), 201);
    }

    public function updateNode(Request $request, $node): JsonResponse
    {
        $node = Node::findOrFail($node);

        $data = $request->validate([
            'label' => 'required|string|max:255',
            'device_id' => 'nullable|integer|exists:devices,device_id',
            'description' => 'nullable|string|max:65535',
        ]);

        $node->update($data);

        return response()->json($this->presentNode($node->load('device')));
    }

    public function deleteNode($node): JsonResponse
    {
        Node::findOrFail($node)->delete();

        return response()->json(['message' => 'Node deleted']);
    }

    // ------------------------------------------------------------------
    // Device lookup
    // ------------------------------------------------------------------

    public function searchDevices(Request $request): JsonResponse
    {
        $query = trim((string) $request->get('q', ''));

        if (mb_strlen($query) < 2) {
            return response()->json([]);
        }

        $like = '%' . addcslashes($query, '%_\\') . '%';

        $devices = Device::hasAccess($request->user())
            ->where(function ($q) use ($like) {
                $q->where('hostname', 'LIKE', $like)
                  ->orWhere('display', 'LIKE', $like)
                  ->orWhere('sysName', 'LIKE', $like);
            })
            ->orderBy('hostname')
            ->limit(20)
            ->get(self::DEVICE_COLUMNS);

        return response()->json($devices->map(fn ($d) => [
            'id' => $d->device_id,
            'text' => $d->display ?: $d->hostname,
            'hostname' => $d->hostname,
            'status_light' => $this->getStatusLight($d),
        ])->values());
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------

    private function validateRack(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'size' => 'required|integer|in:42,48',
            'layout' => 'required|string|in:standard,telecom',
            'description' => 'nullable|string|max:65535',
        ]);
    }

    private function validateServer(Request $request, bool $creating): array
    {
        $rules = [
            'panel' => 'required|string|in:main,side-left,side-right',
            'name' => 'required|string|max:255',
            'u_height' => 'required|integer|min:1|max:8',
            'u_position' => 'required|integer|min:1',
            'num_nodes' => 'required|integer|min:1|max:4',
            'description' => 'nullable|string|max:65535',
            'slot_position' => 'required|string|in:full,left,right',
            'side' => 'required|string|in:both,front,back',
            'color' => ['nullable', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'],
        ];

        if ($creating) {
            $rules['rack_id'] = 'required|integer|exists:rack_builder_racks,id';
        }

        return $request->validate($rules);
    }

    /**
     * Returns an error message if the server cannot be placed, null if it fits.
     */
    private function checkPlacement(Rack $rack, array $data, ?int $excludeId): ?string
    {
        $height = (int) $data['u_height'];
        $pos = (int) $data['u_position'];
        $isSide = $data['panel'] !== 'main';

        if ($isSide) {
            if ($rack->layout !== 'telecom') {
                return 'Side panels are only available on telecom racks';
            }
            if ($height > 2) {
                return 'Side panel server height must be 1U or 2U';
            }
            if ($height === 2 && !in_array($pos, [1, 3, 5], true)) {
                return 'A 2U side panel server must start at U1, U3 or U5';
            }
            if ($data['slot_position'] !== 'full' || $data['side'] !== 'both') {
                return 'Side panel servers must be full width, front & back';
            }
        }

        $maxPosition = $isSide ? self::SIDE_PANEL_SIZE : (int) $rack->size;
        if ($pos + $height - 1 > $maxPosition) {
            return 'Server exceeds panel height (U' . $maxPosition . ')';
        }

        if ($this->hasOverlap($rack->id, $data['panel'], $pos, $height, $data['slot_position'], $data['side'], $excludeId)) {
            return 'Position overlaps with an existing server';
        }

        return null;
    }

    private function hasOverlap(int $rackId, string $panel, int $start, int $height, string $slot, string $side, ?int $excludeId): bool
    {
        $end = $start + $height - 1;

        return Server::where('rack_id', $rackId)
            ->where('panel', $panel)
            ->when($excludeId !== null, fn ($q) => $q->where('id', '!=', $excludeId))
            // Only fetch servers whose U range intersects ours.
            ->where('u_position', '<=', $end)
            ->whereRaw('u_position + u_height - 1 >= ?', [$start])
            ->get(['slot_position', 'side'])
            ->contains(function ($s) use ($slot, $side) {
                // Servers mounted on opposite faces never collide.
                if ($side !== 'both' && $s->side !== 'both' && $side !== $s->side) {
                    return false;
                }

                return $slot === 'full' || $s->slot_position === 'full' || $slot === $s->slot_position;
            });
    }

    private function syncServerNodes(Server $server, int $targetCount): void
    {
        $existing = $server->nodes()->pluck('node_number')->all();

        for ($i = 1; $i <= $targetCount; $i++) {
            if (!in_array($i, $existing, true)) {
                $server->nodes()->create(['node_number' => $i, 'label' => 'Node ' . $i]);
            }
        }

        $server->nodes()->where('node_number', '>', $targetCount)->delete();
    }

    private function presentNode(Node $node): array
    {
        $data = $node->toArray();
        $device = $node->device;

        $data['device'] = $device ? [
            'device_id' => $device->device_id,
            'hostname' => $device->hostname,
            'display' => $device->display ?: $device->hostname,
            'status' => (int) $device->status,
            'disabled' => (int) $device->disabled,
            'ignore' => (int) $device->ignore,
            'uptime' => $device->uptime,
        ] : null;
        $data['status_light'] = $this->getStatusLight($device);

        return $data;
    }

    private function getStatusLight($device): string
    {
        if (!$device) {
            return 'grey';
        }

        if ((int) $device->disabled === 1 || (int) $device->ignore === 1) {
            return 'black';
        }

        if ((int) $device->status === 0) {
            return 'red';
        }

        if ($device->uptime && (int) $device->uptime < self::RECENT_REBOOT_SECONDS) {
            return 'yellow';
        }

        return 'green';
    }

    private function error(string $message, int $code = 422): JsonResponse
    {
        return response()->json(['error' => $message], $code);
    }
}
