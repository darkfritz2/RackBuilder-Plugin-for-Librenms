<?php

namespace App\Plugins\RackBuilder\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Plugins\RackBuilder\Models\Rack;
use App\Plugins\RackBuilder\Models\Server;
use App\Plugins\RackBuilder\Models\Node;
use App\Models\Device;

class RackBuilderController extends Controller
{
    public function listRacks()
    {
        return response()->json(Rack::orderBy('name')->get());
    }

    public function createRack(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'size' => 'required|integer|in:42,48',
            'layout' => 'required|string|in:standard,telecom',
            'description' => 'nullable|string|max:65535',
        ]);

        $rack = Rack::create($data);

        return response()->json($rack, 201);
    }

    public function updateRack(Request $request, $rack)
    {
        $rack = Rack::findOrFail($rack);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'size' => 'required|integer|in:42,48',
            'layout' => 'required|string|in:standard,telecom',
            'description' => 'nullable|string|max:65535',
        ]);

        $rack->update($data);

        return response()->json($rack);
    }

    public function deleteRack($rack)
    {
        $rack = Rack::findOrFail($rack);
        $rack->delete();

        return response()->json(['message' => 'Rack deleted']);
    }

    public function getServers($rack)
    {
        $rack = Rack::with('servers.nodes.device')->findOrFail($rack);

        $result = [
            'rack' => [
                'id' => $rack->id,
                'name' => $rack->name,
                'size' => $rack->size,
                'layout' => $rack->layout,
                'description' => $rack->description,
            ],
            'servers' => [],
        ];

        foreach ($rack->servers->sortBy('u_position') as $server) {
            $serverData = $server->toArray();
            $serverData['nodes'] = [];

            foreach ($server->nodes as $node) {
                $nodeData = $node->toArray();
                $nodeData['device'] = null;
                $nodeData['status_light'] = 'grey';

                if ($node->device) {
                    $statusLight = $this->getStatusLight($node->device);
                    $nodeData['device'] = [
                        'device_id' => $node->device->device_id,
                        'hostname' => $node->device->hostname,
                        'display' => $node->device->display ?? $node->device->hostname,
                        'status' => (int) $node->device->status,
                        'disabled' => (int) $node->device->disabled,
                        'ignore' => (int) $node->device->ignore,
                        'uptime' => $node->device->uptime,
                    ];
                    $nodeData['status_light'] = $statusLight;
                }

                $serverData['nodes'][] = $nodeData;
            }

            $result['servers'][] = $serverData;
        }

        return response()->json($result);
    }

    public function createServer(Request $request)
    {
        $data = $request->validate([
            'rack_id' => 'required|integer|exists:rack_builder_racks,id',
            'panel' => 'required|string|in:main,side-left,side-right',
            'name' => 'required|string|max:255',
            'u_height' => 'required|integer|min:1|max:8',
            'u_position' => 'required|integer|min:1',
            'num_nodes' => 'required|integer|min:1|max:4',
            'description' => 'nullable|string|max:65535',
            'slot_position' => 'required|string|in:full,left,right',
            'side' => 'required|string|in:both,front,back',
            'color' => 'nullable|string|max:7',
        ]);

        $rack = Rack::findOrFail($data['rack_id']);

        if ($data['panel'] !== 'main') {
            $height = (int) $data['u_height'];
            $pos = (int) $data['u_position'];
            if ($height < 1 || $height > 2) {
                return response()->json(['error' => 'Side panel server height must be 1U or 2U'], 422);
            }
            if (!in_array($pos, $height === 2 ? [1, 3, 5] : range(1, 6))) {
                return response()->json(['error' => 'Invalid position for side panel server'], 422);
            }
            if ($data['slot_position'] !== 'full' || $data['side'] !== 'both') {
                return response()->json(['error' => 'Side panel servers must be full width, front & back'], 422);
            }
        }

        $maxPosition = $data['panel'] === 'main' ? $rack->size : 12;
        if ($data['u_position'] + $data['u_height'] - 1 > $maxPosition) {
            return response()->json(['error' => 'Server exceeds panel height'], 422);
        }

        if ($this->hasOverlap($rack->id, $data['panel'], $data['u_position'], $data['u_height'], $data['slot_position'], $data['side'], null)) {
            return response()->json(['error' => 'Position overlaps with an existing server'], 422);
        }

        $server = Server::create($data);

        for ($i = 1; $i <= $data['num_nodes']; $i++) {
            $label = $data['num_nodes'] === 1 ? $data['name'] : 'Node ' . $i;
            $server->nodes()->create([
                'node_number' => $i,
                'label' => $label,
                'device_id' => null,
                'description' => null,
            ]);
        }

        return response()->json($server->load('nodes'), 201);
    }

    public function updateServer(Request $request, $server)
    {
        $server = Server::findOrFail($server);

        $data = $request->validate([
            'panel' => 'required|string|in:main,side-left,side-right',
            'name' => 'required|string|max:255',
            'u_height' => 'required|integer|min:1|max:8',
            'u_position' => 'required|integer|min:1',
            'num_nodes' => 'required|integer|min:1|max:4',
            'description' => 'nullable|string|max:65535',
            'slot_position' => 'required|string|in:full,left,right',
            'side' => 'required|string|in:both,front,back',
            'color' => 'nullable|string|max:7',
        ]);

        $rack = Rack::findOrFail($server->rack_id);

        if ($data['panel'] !== 'main') {
            $height = (int) $data['u_height'];
            $pos = (int) $data['u_position'];
            if ($height < 1 || $height > 2) {
                return response()->json(['error' => 'Side panel server height must be 1U or 2U'], 422);
            }
            if (!in_array($pos, $height === 2 ? [1, 3, 5] : range(1, 6))) {
                return response()->json(['error' => 'Invalid position for side panel server'], 422);
            }
            if ($data['slot_position'] !== 'full' || $data['side'] !== 'both') {
                return response()->json(['error' => 'Side panel servers must be full width, front & back'], 422);
            }
        }

        $maxPosition = $data['panel'] === 'main' ? $rack->size : 12;
        if ($data['u_position'] + $data['u_height'] - 1 > $maxPosition) {
            return response()->json(['error' => 'Server exceeds panel height'], 422);
        }

        if ($this->hasOverlap($rack->id, $data['panel'], $data['u_position'], $data['u_height'], $data['slot_position'], $data['side'], $server->id)) {
            return response()->json(['error' => 'Position overlaps with an existing server'], 422);
        }

        $server->update($data);

        $this->syncServerNodes($server, $data['num_nodes']);

        return response()->json($server->load('nodes'));
    }

    public function deleteServer($server)
    {
        $server = Server::findOrFail($server);
        $server->delete();

        return response()->json(['message' => 'Server deleted']);
    }

    public function createNode(Request $request)
    {
        $data = $request->validate([
            'server_id' => 'required|integer|exists:rack_builder_servers,id',
            'node_number' => 'required|integer|min:1|max:4',
            'label' => 'required|string|max:255',
            'device_id' => 'nullable|integer',
            'description' => 'nullable|string|max:65535',
        ]);

        $server = Server::findOrFail($data['server_id']);

        $existing = Node::where('server_id', $server->id)
            ->where('node_number', $data['node_number'])
            ->first();

        if ($existing) {
            return response()->json(['error' => 'Node number already exists for this server'], 422);
        }

        $node = Node::create($data);

        return response()->json($node, 201);
    }

    public function updateNode(Request $request, $node)
    {
        $node = Node::findOrFail($node);

        $data = $request->validate([
            'label' => 'required|string|max:255',
            'device_id' => 'nullable|integer',
            'description' => 'nullable|string|max:65535',
        ]);

        $node->update($data);

        $node->load('device');
        $nodeData = $node->toArray();
        $nodeData['device'] = null;
        $nodeData['status_light'] = 'grey';

        if ($node->device) {
            $nodeData['device'] = [
                'device_id' => $node->device->device_id,
                'hostname' => $node->device->hostname,
                'display' => $node->device->display ?? $node->device->hostname,
                'status' => (int) $node->device->status,
                'disabled' => (int) $node->device->disabled,
                'ignore' => (int) $node->device->ignore,
                'uptime' => $node->device->uptime,
            ];
            $nodeData['status_light'] = $this->getStatusLight($node->device);
        }

        return response()->json($nodeData);
    }

    public function deleteNode($node)
    {
        $node = Node::findOrFail($node);
        $node->delete();

        return response()->json(['message' => 'Node deleted']);
    }

    public function searchDevices(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $devices = Device::hasAccess($request->user())
            ->where(function ($q) use ($query) {
                $q->where('hostname', 'LIKE', "%{$query}%")
                  ->orWhere('display', 'LIKE', "%{$query}%")
                  ->orWhere('sysName', 'LIKE', "%{$query}%");
            })
            ->limit(20)
            ->get(['device_id', 'hostname', 'display', 'status', 'disabled', 'ignore', 'uptime', 'os']);

        return response()->json($devices->map(function ($d) {
            return [
                'id' => $d->device_id,
                'text' => $d->display ?? $d->hostname,
                'hostname' => $d->hostname,
                'status_light' => $this->getStatusLight($d),
            ];
        }));
    }

    public function getStatus($rack)
    {
        $rack = Rack::findOrFail($rack);

        $servers = Server::where('rack_id', $rack->id)->with('nodes')->get();
        $deviceIds = [];

        foreach ($servers as $server) {
            foreach ($server->nodes as $node) {
                if ($node->device_id) {
                    $deviceIds[] = $node->device_id;
                }
            }
        }

        $deviceIds = array_unique($deviceIds);
        $devices = [];

        if (!empty($deviceIds)) {
            $devices = Device::whereIn('device_id', $deviceIds)
                ->get(['device_id', 'status', 'disabled', 'ignore', 'uptime'])
                ->keyBy('device_id');
        }

        $statuses = [];

        foreach ($servers as $server) {
            foreach ($server->nodes as $node) {
                $device = $devices->get($node->device_id);
                $statuses[(int) $node->id] = [
                    'device_id' => $node->device_id,
                    'status' => $device ? (int) $device->status : null,
                    'disabled' => $device ? (int) $device->disabled : null,
                    'ignore' => $device ? (int) $device->ignore : null,
                    'uptime' => $device ? (int) $device->uptime : null,
                    'status_light' => $device ? $this->getStatusLight($device) : 'grey',
                ];
            }
        }

        return response()->json($statuses);
    }

    private function syncServerNodes($server, $targetCount)
    {
        $existing = $server->nodes()->count();

        if ($targetCount > $existing) {
            for ($i = $existing + 1; $i <= $targetCount; $i++) {
                $server->nodes()->create([
                    'node_number' => $i,
                    'label' => 'Node ' . $i,
                    'device_id' => null,
                    'description' => null,
                ]);
            }
        } elseif ($targetCount < $existing) {
            $server->nodes()->where('node_number', '>', $targetCount)->delete();
        }
    }

    private function getStatusLight($device)
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

        if ($device->uptime && (int) $device->uptime < 86400) {
            return 'yellow';
        }

        return 'green';
    }

    private function hasOverlap($rackId, $panel, $position, $height, $slotPosition, $side, $excludeId)
    {
        $start = (int) $position;
        $end = $start + (int) $height - 1;

        $servers = Server::where('rack_id', $rackId)->where('panel', $panel);

        if ($excludeId !== null) {
            $servers->where('id', '!=', $excludeId);
        }

        foreach ($servers->get() as $s) {
            $sStart = (int) $s->u_position;
            $sEnd = $sStart + (int) $s->u_height - 1;

            if (!($start <= $sEnd && $end >= $sStart)) {
                continue;
            }

            // Servers on opposite sides don't overlap
            if ($side !== 'both' && $s->side !== 'both' && $side !== $s->side) {
                continue;
            }

            if ($slotPosition === 'full' || $s->slot_position === 'full') {
                return true;
            }

            if ($slotPosition === $s->slot_position) {
                return true;
            }
        }

        return false;
    }
}
