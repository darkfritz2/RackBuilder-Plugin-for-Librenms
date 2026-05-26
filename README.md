# RackBuilder-Plugin-for-Librenms
This is a small plugin for LibreNMS to add Datacenter Rack. It's completely made with AI.

# RackBuilder Plugin for LibreNMS

## Overview
A rack diagram/builder plugin for LibreNMS that allows you to create visual representations of physical server racks. Each server/node can be linked to an existing LibreNMS-monitored device, showing live status as colored bulbs.

## Requirements
- LibreNMS 26.5.0
- PHP 8.1+
- The V2 plugin system (auto-detected by LibreNMS)

## File Structure

```
app/Plugins/RackBuilder/
    Menu.php                              # Sidebar navigation link
    Page.php                              # Main page + route registration
    Http/Controllers/
        RackBuilderController.php         # All CRUD + status logic
    Models/
        Rack.php                          # Rack Eloquent model
        Server.php                        # Server/chassis Eloquent model
        Node.php                          # Node Eloquent model
    resources/views/
        menu.blade.php                    # Sidebar link template
        page.blade.php                    # Full UI: grids, modals, JS

database/migrations/
    2026_05_19_000001_create_rack_builder_tables.php
```

## Database Structure

3 new tables are created alongside LibreNMS's existing tables. They are never altered by LibreNMS updates.

### `rack_builder_racks`

| Column      | Type         | Description                              |
|-------------|--------------|------------------------------------------|
| id          | INT PK auto  |                                          |
| name        | VARCHAR(255) | Rack name/label                          |
| size        | TINYINT      | 42 or 48 U                               |
| layout      | VARCHAR(20)  | `standard` (default)                     |
| description | TEXT         | Editable description                     |
| created_at  | TIMESTAMP    |                                          |
| updated_at  | TIMESTAMP    |                                          |

### `rack_builder_servers`

| Column      | Type         | Description                              |
|-------------|--------------|------------------------------------------|
| id          | INT PK auto  |                                          |
| rack_id     | INT FK       | → `rack_builder_racks.id` (cascade delete)|
| panel       | VARCHAR(20)  | `main` (default) — reserved for side-panel racks |
| name        | VARCHAR(255) | Server/chassis name                      |
| u_height    | TINYINT      | 1 to 8 (U slots occupied)                |
| u_position  | TINYINT      | Starting U position (1 = bottom)         |
| num_nodes   | TINYINT      | 1, 2, or 4 (display descriptor)          |
| description | TEXT         |                                          |
| color       | VARCHAR(7)   | Hex color for the block (e.g., #3a6ea5)  |
| slot_position | VARCHAR(5) | `full`, `left`, or `right` (half-width) |
| side        | VARCHAR(5)   | `both` (default), `front`, or `back`     |
| created_at  | TIMESTAMP    |                                          |
| updated_at  | TIMESTAMP    |                                          |

### `rack_builder_nodes`

| Column      | Type         | Description                              |
|-------------|--------------|------------------------------------------|
| id          | INT PK auto  |                                          |
| server_id   | INT FK       | → `rack_builder_servers.id` (cascade delete)|
| node_number | TINYINT      | 1 to 4                                   |
| label       | VARCHAR(255) | Node label (e.g., "Node A", "Web-01")   |
| device_id   | INT NULLABLE | → `devices.device_id` (no FK constraint) |
| description | TEXT         |                                          |
| created_at  | TIMESTAMP    |                                          |
| updated_at  | TIMESTAMP    |                                          |

**No foreign key to `devices.device_id`** — device_id is stored as a plain integer to avoid issues if a device is deleted from LibreNMS.

## Plugin System Integration

### Hooks Used

- **`MenuEntryHook`** (`Menu.php`) — Adds "RackBuilder" link to the sidebar
- **`PageHook`** (`Page.php`) — Full-page plugin view at `/plugin/RackBuilder`

### Auto-Discovery

LibreNMS's `PluginProvider` scans `app/Plugins/*/*.php` at boot. Files in `RackBuilder/` are detected, their hook interfaces are checked via `class_implements()`, and they are registered with the `PluginManager`. Views are registered via `loadViewsFrom()` under the namespace `RackBuilder::`.

### Route Registration (Important Pattern)

The `Page.php` constructor registers all API routes dynamically using the `Route` facade:

```php
public function __construct()
{
    if (!app()->routesAreCached()) {
        Route::prefix('plugin/RackBuilder/api')
            ->middleware(['web', 'auth'])
            ->group(function () { /* ... */ });
    }
}
```

This works because `PluginProvider` instantiates the hook classes during `boot()`, which runs before Laravel matches routes. The `web` middleware group is required for session/auth/CSRF support (our routes are NOT in `routes/web.php`).

**All controller method parameters MUST match route parameter names** — Laravel dispatches by parameter name, not position. Route `{rack}` → method param `$rack`, route `{server}` → method param `$server`, etc.

## API Endpoints

All under `/plugin/RackBuilder/api/`, requires authentication.

| Method | Endpoint | Controller Method | Purpose |
|--------|----------|-------------------|---------|
| GET | `/racks` | `listRacks()` | List all racks |
| POST | `/racks` | `createRack()` | Create rack |
| PUT | `/racks/{rack}` | `updateRack()` | Update rack |
| DELETE | `/racks/{rack}` | `deleteRack()` | Delete rack + cascade servers/nodes |
| GET | `/racks/{rack}/servers` | `getServers()` | Full rack data with servers, nodes, device status |
| GET | `/racks/{rack}/status` | `getStatus()` | Lightweight status-only (for 60s polling) |
| POST | `/servers` | `createServer()` | Create server (validates overlap + rack bounds) |
| PUT | `/servers/{server}` | `updateServer()` | Update server |
| DELETE | `/servers/{server}` | `deleteServer()` | Delete server + cascade nodes |
| POST | `/nodes` | `createNode()` | Create node (validates unique node_number per server) |
| PUT | `/nodes/{node}` | `updateNode()` | Update node, returns updated data with device status |
| DELETE | `/nodes/{node}` | `deleteNode()` | Delete node |
| GET | `/devices/search?q=` | `searchDevices()` | Search LibreNMS devices by hostname/display/sysName |

## Status Bulb Colors

Computed in `RackBuilderController::getStatusLight($device)`:

| Condition | Color |
|-----------|-------|
| No device linked (`device_id` is NULL) | Grey outline (no status) |
| `disabled = 1` or `ignore = 1` | Black |
| `status = 0` (down/unreachable) | Red |
| `status = 1` AND `uptime < 86400` (restarted <24h ago) | Yellow |
| `status = 1` AND `uptime >= 86400` (stable) | Green |

The 86400 second threshold (24 hours) matches LibreNMS's `uptime_warning` default.

## View Modes

Each rack has two view modes toggled by a button in the toolbar:

### Normal View (28px rows)
Standard full-size view with 28px rows and 9px node text. Default mode.

### Compact View (20px rows)
Dense view with 20px rows, 7px node text, and 5px status bulbs. No borders on server blocks, minimal padding. Useful for high-density racks (e.g., 48U with many 1U servers).

The toggle button switches between both modes. The grid re-renders in-place.

| Feature | Normal | Compact |
|---------|--------|---------|
| Row height | 28px | 20px |
| Font size | 9px | 7px |
| Bulb size | 7px | 5px |
| Border | 1px solid | none |
| Border radius | 3px | 2px |
| Node text | Device display / label | Same (smaller) |

### Front/Back Views within each mode

Both front and back views display the same server blocks in the same U positions. The back view:
- Has reduced opacity (`opacity: 0.85`) and dashed borders
- Hides server action buttons (add node, delete)
- No click-to-edit on server blocks
- Header says "Back" instead of "Front"

Grids use CSS grid with `grid-template-rows: repeat(N, <row-height>px)` where N is the rack size.

## Auto-Refresh (Status Polling)

- JavaScript calls `GET /racks/{rack}/status` every **60 seconds**
- Response contains only device status data (lightweight: status, uptime, disabled, ignore per node)
- Bulb CSS classes are updated in-place without page reload
- A brief pulse animation indicates updated bulbs
- Polling stops when no rack is selected; restarts when a rack is selected

## LibreNMS Conventions Used

- Namespace: `App\Plugins\RackBuilder\`
- Controller extends `Illuminate\Routing\Controller`
- Models extend `Illuminate\Database\Eloquent\Model`
- Device model: `App\Models\Device` (primary key `device_id`)
- Device search uses `Device::hasAccess($user)` scope for permissions
- Device page URL: `/device/{device_id}`
- Frontend uses Bootstrap 3 modals (`jQuery(...).modal('show')`)
- CSRF token read from `<meta name="csrf-token">`
- API calls include `X-Requested-With: XMLHttpRequest` + `X-CSRF-TOKEN` headers
- CSS respects LibreNMS dark theme colors

## JavaScript Architecture

The entire UI is rendered client-side in `page.blade.php`.

Key functions in the IIFE `window.RackBuilder`:

| Function | Purpose |
|----------|---------|
| `q(sel, ctx)` | `document.querySelector()` wrapper (aliased as `q` to avoid jQuery conflict) |
| `qa(sel, ctx)` | `document.querySelectorAll()` wrapper |
| `apiFetch(method, path, body)` | Fetch wrapper with CSRF/JSON headers |
| `loadRacks()` | Fetches rack list, populates selector |
| `selectRack(id)` | Selects a rack from the dropdown |
| `loadRackData(id)` | Fetches full rack data and renders grids |
| `renderGrid(containerId, size, servers, view)` | Renders one half (front or back) |
| `buildServerHTML(svr, view)` | Generates HTML for a server block (normal view) |
| `buildCompactServerHTML(svr, view)` | Generates HTML for a compact server block with node grid |
| `getBulbColor(cls)` | Returns CSS color string for a status light class |
| `buildBulbsHTML(svr)` | Generates status bulb indicators for a server |
| `startPolling(rackId)` | Starts 60-second status refresh interval |
| `pollStatus(rackId)` | Fetches status data and updates bulbs |
| `showRackModal(rack)` | Opens rack create/edit modal |
| `saveRack(event)` | Saves rack (create or update) |
| `deleteCurrentRack()` | Deletes selected rack after confirmation |
| `showServerModal(server)` | Opens server create/edit modal |
| `updatePositionOptions()` | Updates position dropdown based on height and rack size |
| `saveServer(event)` | Saves server (create or update) |
| `editServer(id)` | Opens edit modal for existing server |
| `deleteServer(id)` | Deletes a server after confirmation |
| `showNodeModal(node, serverId)` | Opens node create/edit modal |
| `editNode(nodeId, serverId)` | Finds node data and opens edit modal |
| `saveNode(event)` | Saves node (create or update) |
| `wasDragging()` | Returns true if a drag operation is in progress (used to prevent click during drag) |
| `makeBlock(svr, topRow, span, view)` | Creates a server block DOM element with drag attributes (normal view) |
| `makeCompactBlock(svr, topRow, span, view)` | Creates a compact server block DOM element with drag attributes |
| `showDropPreview(zone)` | Shows green/red drop preview overlay during drag |
| `cleanupDrag()` | Removes drag ghost and resets drag state |
| `toggleCompact()` | Toggles between compact (20px) and normal (28px) view modes |
| `getRowHeight()` | Returns current row height based on compact mode |

## Half-Width Devices

Servers can be placed as:
- **Full Width** (default) — occupies the entire rack width
- **Left Half** — occupies the left 50% of the rack
- **Right Half** — occupies the right 50% of the rack

Two half-width servers can coexist in the same U position as long as one is `left` and the other is `right`. A `full`-width server conflicts with anything.

Half-width is useful for:
- 1U patch panels
- Power strips / PDUs
- Half-width switches
- Blade chassis components

### Collision Logic (for half-width)

| Server A | Server B | Same U? |
|----------|----------|---------|
| full | anything | Conflict |
| left | left | Conflict |
| left | right | OK |
| right | right | Conflict |
| right | left | OK |

## Drag and Drop

Servers can be repositioned by dragging them to a new U position within the front view grid:

1. **Grab** a server block (cursor changes to `grab`)
2. **Drag** it up or down within the rack
3. **Drop** on an empty U slot
4. The server snaps to the nearest U position
5. A **green preview** overlay shows valid drop positions; **red** indicates a conflict
6. On drop, the API is called to update position + slot

**Implementation notes:**
- Uses HTML5 Drag and Drop API
- Custom drag ghost (floating label with server name + height)
- Only works on the front view (back view is read-only for drag)
- Server blocks use `draggable="true"` on the `drag-server` CSS class
- Click-to-edit still works (click is suppressed if a drag occurred)
- Drop zones are marked with `drop-zone` class on empty left/right cells

## Adding a Server

1. Click "Add Server" button below the grid
2. Fill in: Name, Height (1U-8U), Position (dropdown shows valid positions), Node Slots (1/2/4), Width (Full/Left/Right), Description
3. Pick a color for the block
4. Save → appears in both front/back views
5. Click the "+" button on the server block → Add Node modal
6. Fill in: Label, search for a LibreNMS device to link (optional), Description
7. Save → appears inside the server block with a status bulb

## Edit Flow

- **Server**: Click the server block in the front view → edit modal opens
- **Node**: Click the node row inside any server block → edit modal opens
- **Rack**: Click "Edit" button in toolbar → edit modal opens

## Device Search

When linking a node to a LibreNMS device:
- Type at least 2 characters in the search input
- Results appear in a dropdown below the input
- Each result shows the device hostname and a status bulb
- Click a result to select → hidden `device_id` field is populated
- Can clear by deleting the input text

## Installation

```bash
# 1. Copy plugin directories
cp -r app/Plugins/RackBuilder /opt/librenms/app/Plugins/RackBuilder

# 2. Copy migration
cp database/migrations/2026_05_19_000001_create_rack_builder_tables.php /opt/librenms/database/migrations/

# 3. Run migration
cd /opt/librenms
php artisan migrate

# 4. Clear cache
php artisan optimize:clear

# 5. Enable in WebUI: Overview → Plugins → enable RackBuilder
```

## Troubleshooting

### "404 Not Found" when accessing the plugin page
- Make sure the plugin is enabled in Overview → Plugins
- Run `php artisan optimize:clear` to clear route cache

### "500 Internal Server Error" on API calls
- Check that migration ran successfully: `php artisan migrate:status`
- Check storage/logs/laravel.log for the error

### Devices not showing in search
- Type at least 2 characters
- Check that the user has permission to view the device (hasAccess scope)

### Status bulbs not updating
- The 60-second poll interval is running — check browser console for errors
- Verify the device is still being polled by LibreNMS (check device overview)

### Modals not opening
- LibreNMS uses Bootstrap 3 which requires jQuery. If jQuery is not loaded, modals will fail.
- The JS uses `jQuery(...).modal('show')` explicitly (not `$`) to avoid conflicts.

## Common Modifications

### Change polling interval
In `page.blade.php`, change `60000` (milliseconds) in `startPolling()`.

### Change reboot threshold
In `RackBuilderController.php`, change `86400` (seconds) in `getStatusLight()`.

### Add more rack sizes
- Migration: change the `size` column validation or remove the `in:42,48` constraint
- Controller: update validation rules in `createRack` and `updateRack`
- View: update the size dropdown options in `page.blade.php`

### Add drag-and-drop support
Add `sortablejs` or native drag/drop API to `renderGrid()`, then call `updateServer()` API on drop.

### Add device auto-import
Extend `getServers()` to also return unassigned devices. Create an "Auto-add" button in the UI that places unracked devices.
