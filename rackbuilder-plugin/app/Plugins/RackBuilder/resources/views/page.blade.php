<style>
#rack-builder .rack-grid-wrapper { display: flex; gap: 20px; align-items: flex-start; }
#rack-builder .rack-panel { flex: 1; min-width: 0; }
#rack-builder .rack-panel h4 { text-align: center; margin-bottom: 8px; font-weight: 600; }
#rack-builder .rack-grid { display: grid; grid-template-columns: 32px 1fr 1fr; gap: 1px; background: #2d2d2d; border: 2px solid #555; border-radius: 4px; padding: 2px; }
#rack-builder .u-label { display: flex; align-items: center; justify-content: center; font-size: 10px; color: #aaa; background: #1e1e1e; height: 28px; }
#rack-builder .empty-slot { background: #2a2a2a; height: 28px; border: 1px dashed #3a3a3a; }
#rack-builder .empty-slot-left { grid-column: 2; border-right: 1px dashed #333; }
#rack-builder .empty-slot-right { grid-column: 3; }
#rack-builder .server-block { position: relative; border: 1px solid rgba(255,255,255,0.15); border-radius: 3px; padding: 1px; cursor: grab; min-height: 28px; display: flex; flex-direction: column; }
#rack-builder .server-block:active { cursor: grabbing; }
#rack-builder .server-block .node-grid { flex: 1; min-height: 0; }
#rack-builder .server-block .server-actions { position: absolute; top: 2px; right: 4px; opacity: 0; transition: opacity .15s; }
#rack-builder .server-block:hover .server-actions { opacity: 1; }
#rack-builder .server-block .server-actions .btn-xs { padding: 0 4px; font-size: 10px; line-height: 1.4; }
#rack-builder .node-row { font-size: 9px; color: rgba(255,255,255,0.85); display: flex; align-items: center; gap: 2px; padding: 0 1px; cursor: pointer; background: rgba(0,0,0,0.12); border-radius: 2px; overflow: hidden; }
#rack-builder .device-link { color: inherit; text-decoration: underline; text-decoration-color: rgba(255,255,255,0.3); cursor: pointer; }
#rack-builder .device-link:hover { color: #fff; }
#rack-builder[data-rack-theme="light"] .device-link { text-decoration-color: rgba(0,0,0,0.3); }
#rack-builder[data-rack-theme="light"] .device-link:hover { color: #000; }

/* status bulbs */
.status-bulb { display: inline-block; width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
.status-bulb.green { background: #5cff5c; box-shadow: 0 0 4px #5cff5c; }
.status-bulb.yellow { background: #ffee33; box-shadow: 0 0 4px #ffee33; }
.status-bulb.red { background: #ff3333; box-shadow: 0 0 4px #ff3333; }
.status-bulb.black { background: #555; box-shadow: 0 0 2px #555; }
.status-bulb.grey { background: #444; border: 1px solid #666; }
.status-bulb.pulse { animation: bulb-pulse 1.5s ease-in-out infinite; }
@keyframes bulb-pulse { 0%,100% { opacity: 1; } 50% { opacity: 0.4; } }

/* toolbar */
#rack-builder .toolbar { display: flex; align-items: center; gap: 10px; margin-bottom: 16px; flex-wrap: wrap; }
#rack-builder .toolbar select { width: auto; min-width: 220px; }
#rack-builder .rack-info { flex: 1; font-size: 13px; color: #aaa; }

/* transitions */
#rack-builder .rack-grid-wrapper { transition: opacity .3s; }
#rack-builder .rack-grid-wrapper.loading { opacity: 0.4; pointer-events: none; }
.fade-in { animation: fadeIn .2s; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: translateY(0); } }

/* device search dropdown */
.device-search-wrap { position: relative; }
.device-search-results { position: absolute; top: 100%; left: 0; right: 0; z-index: 1050; max-height: 200px; overflow-y: auto; background: #2d2d2d; border: 1px solid #555; border-radius: 0 0 4px 4px; display: none; }
.device-search-results .ds-item { padding: 6px 10px; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 13px; }
.device-search-results .ds-item:hover { background: rgba(255,255,255,0.08); }
.device-search-results .ds-item .ds-name { flex: 1; }
.device-search-results .ds-item .ds-status { font-size: 10px; padding: 1px 6px; border-radius: 3px; }

/* rack view container for zoom scrolling */
#rack-builder #rack-view { overflow: auto; max-width: 100%; }

/* Add server floating button */
#rack-builder .add-server-btn-wrap { text-align: center; margin-top: 12px; }
#rack-builder .add-server-btn-wrap .btn { border-style: dashed; opacity: 0.7; }
#rack-builder .add-server-btn-wrap .btn:hover { opacity: 1; }

/* side panel adjustments */
#rack-builder .rack-sidepanel { flex: 0 0 auto; min-width: 90px; }
#rack-builder .rack-sidepanel h4 { text-align: center; margin-bottom: 8px; font-weight: 600; font-size: 11px; }
#rack-builder .rack-sidepanel .side-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1px; background: #2d2d2d; border: 1px solid #555; border-radius: 3px; padding: 2px; }
#rack-builder[data-rack-theme="light"] .rack-sidepanel .side-grid { background: #d0d0d0; border-color: #bbb; }

/* panel adjustments */
#rack-builder .server-block-back { opacity: 0.85; border-style: dashed; }
#rack-builder .server-block-back .server-actions { display: none; }
#rack-builder .panel { margin-bottom: 0; }

/* drag and drop */
#rack-builder .rack-grid.drag-active .empty-slot-left,
#rack-builder .rack-grid.drag-active .empty-slot-right,
#rack-builder .rack-grid.drag-active .u-label { cursor: crosshair; }
#rack-builder .drop-preview-wrap { position: relative; }
#rack-builder .drop-preview { pointer-events: none; border: 2px dashed rgba(255,255,255,0.5); background: rgba(92,184,92,0.15); border-radius: 3px; z-index: 10; }
#rack-builder .drop-preview.invalid { border-color: #ff3333; background: rgba(217,83,79,0.15); }
#rack-builder .drag-ghost { position: fixed; pointer-events: none; z-index: 9999; opacity: 0.85; transform: rotate(3deg); box-shadow: 0 8px 24px rgba(0,0,0,0.4); border-radius: 3px; padding: 6px 10px; color: #fff; font-size: 12px; font-weight: 700; white-space: nowrap; }

/* theme: light rack */
#rack-builder[data-rack-theme="light"] .rack-grid { background: #d0d0d0; border-color: #bbb; }
#rack-builder[data-rack-theme="light"] .u-label { color: #555; background: #e8e8e8; }
#rack-builder[data-rack-theme="light"] .empty-slot { background: #f5f5f5; border-color: #ccc; }
#rack-builder[data-rack-theme="light"] .empty-slot-left { border-right: 1px solid #ddd; }
#rack-builder[data-rack-theme="light"] .node-row { color: rgba(0,0,0,0.75); background: rgba(255,255,255,0.5); }
#rack-builder[data-rack-theme="light"] .device-search-results { background: #fff; border-color: #ccc; color: #333; }
#rack-builder[data-rack-theme="light"] .device-search-results .ds-item:hover { background: rgba(0,0,0,0.05); }
#rack-builder[data-rack-theme="light"] .rack-info { color: #666; }
#rack-builder[data-rack-theme="light"] .device-search-wrap .form-control { background: #fff; border-color: #ccc; color: #333; }
#rack-builder[data-rack-theme="light"] .device-search-wrap .form-control::placeholder { color: #999; }

@media print {
    @page { size: landscape; margin: 5mm; }
    #rack-builder .panel-heading,
    #rack-builder .toolbar,
    #rack-builder .add-server-btn-wrap,
    #rack-builder .drop-preview,
    #rack-builder .drag-ghost,
    #rack-builder .rack-info,
    .modal, .modal-backdrop { display: none !important; }
    #rack-builder .server-block { cursor: default; }
    #rack-builder .server-block .server-actions { display: none !important; }
    #rack-builder .server-block-back { opacity: 1; }
    #rack-builder .panel-body { padding: 0; }
    #rack-builder .panel { border: none; box-shadow: none; }
    #rack-builder .rack-grid-wrapper { max-width: 100%; }
}
</style>

<div id="rack-builder" class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">RackBuilder</h3>
        </div>
        <div class="panel-body">
            <div class="toolbar">
                <select id="rack-selector" class="form-control input-sm" onchange="RackBuilder.selectRack(this.value)">
                    <option value="">-- Select a Rack --</option>
                </select>
                <button class="btn btn-sm btn-primary" onclick="RackBuilder.showRackModal(null)">New Rack</button>
                <button class="btn btn-sm btn-default" id="edit-rack-btn" disabled onclick="RackBuilder.showRackModal(RackBuilder.state.currentRack)">Edit</button>
                <button class="btn btn-sm btn-danger"  id="delete-rack-btn" disabled onclick="RackBuilder.deleteCurrentRack()">Delete</button>
                <button class="btn btn-sm btn-default" onclick="RackBuilder.printRack()"><i class="fa fa-print"></i> Print</button>
                <span style="flex:1"></span>
                <button class="btn btn-sm btn-default" onclick="RackBuilder.zoomOut()" title="Zoom out"><i class="fa fa-search-minus"></i></button>
                <span id="zoom-label" style="font-size:12px;color:#aaa;min-width:40px;text-align:center">100%</span>
                <button class="btn btn-sm btn-default" onclick="RackBuilder.zoomIn()" title="Zoom in"><i class="fa fa-search-plus"></i></button>
                <button class="btn btn-sm btn-default" onclick="RackBuilder.zoomReset()" title="Fit"><i class="fa fa-arrows-alt"></i></button>
                <button class="btn btn-sm btn-default" id="compact-toggle-btn" onclick="RackBuilder.toggleCompactView()" title="Toggle compact view"><i class="fa fa-compress"></i></button>
                <span class="rack-info" id="rack-info"></span>
            </div>

            <div id="rack-view" style="display:none">
                <div class="add-server-btn-wrap" style="margin-bottom:10px">
                    <button class="btn btn-sm btn-default" onclick="RackBuilder.showServerModal(null)">
                        <i class="fa fa-plus"></i> Add Server
                    </button>
                </div>
                <div class="rack-grid-wrapper" id="rack-grid-wrapper">
                    <div class="rack-sidepanel" id="side-left-panel" style="display:none">
                        <h4>Side L</h4>
                        <div class="rack-grid side-grid" id="side-left-grid" data-panel="side-left"></div>
                    </div>
                    <div class="rack-panel">
                        <h4>Front</h4>
                        <div class="rack-grid" id="front-rack-grid" data-panel="main"></div>
                    </div>
                    <div class="rack-panel">
                        <h4>Back</h4>
                        <div class="rack-grid" id="back-rack-grid" data-panel="main"></div>
                    </div>
                    <div class="rack-sidepanel" id="side-right-panel" style="display:none">
                        <h4>Side R</h4>
                        <div class="rack-grid side-grid" id="side-right-grid" data-panel="side-right"></div>
                    </div>
                </div>

                <div class="add-server-btn-wrap">
                    <button class="btn btn-sm btn-default" onclick="RackBuilder.showServerModal(null)">
                        <i class="fa fa-plus"></i> Add Server
                    </button>
                </div>
            </div>

            <div id="rack-empty" style="display:none;text-align:center;padding:40px;color:#888">
                <i class="fa fa-server fa-3x"></i>
                <p style="margin-top:12px">Select or create a rack to begin.</p>
            </div>
        </div>
    </div>
</div>

<!-- Rack Modal -->
<div class="modal fade" id="rack-modal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <form id="rack-form" onsubmit="return RackBuilder.saveRack(event)">
        <div class="modal-content">
            <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" id="rack-modal-title">New Rack</h4></div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required maxlength="255">
                </div>
                <div class="form-group">
                    <label>Size</label>
                    <select name="size" class="form-control">
                        <option value="42">42U</option>
                        <option value="48">48U</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Layout</label>
                    <select name="layout" class="form-control">
                        <option value="standard">Standard</option>
                        <option value="telecom">Telecom (with side panels)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
        </form>
    </div>
</div>

<!-- Server Modal -->
<div class="modal fade" id="server-modal" tabindex="-1">
    <div class="modal-dialog">
        <form id="server-form" onsubmit="return RackBuilder.saveServer(event)">
        <div class="modal-content">
            <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" id="server-modal-title">Add Server</h4></div>
            <div class="modal-body">
                <input type="hidden" name="id" id="server-id">
                <div class="form-group" id="panel-group" style="display:none">
                    <label>Panel</label>
                    <select name="panel" class="form-control" onchange="RackBuilder.onPanelChange()">
                        <option value="main">Main Rack</option>
                        <option value="side-left">Side Left</option>
                        <option value="side-right">Side Right</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required maxlength="255">
                </div>
                <div class="form-group">
                    <label>Height (U)</label>
                    <select name="u_height" class="form-control" id="server-height" onchange="RackBuilder.updatePositionOptions()">
                        <option value="1">1U</option>
                        <option value="2">2U</option>
                        <option value="3">3U</option>
                        <option value="4">4U</option>
                        <option value="5">5U</option>
                        <option value="6">6U</option>
                        <option value="7">7U</option>
                        <option value="8">8U</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Position (U)</label>
                    <select name="u_position" class="form-control" id="server-position"></select>
                </div>
                <div class="form-group">
                    <label>Node Slots</label>
                    <select name="num_nodes" class="form-control">
                        <option value="1">1 (Standalone)</option>
                        <option value="2">2 Nodes</option>
                        <option value="4">4 Nodes</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Width</label>
                    <select name="slot_position" class="form-control">
                        <option value="full">Full Width</option>
                        <option value="left">Left Half</option>
                        <option value="right">Right Half</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Side</label>
                    <select name="side" class="form-control">
                        <option value="both">Front &amp; Back</option>
                        <option value="front">Front Only</option>
                        <option value="back">Back Only</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label>Color</label>
                    <div style="display:flex;gap:6px;flex-wrap:wrap" id="color-picker">
                        <label class="color-swatch" style="background:#3a6ea5;width:28px;height:28px;border-radius:3px;cursor:pointer;border:2px solid transparent">
                            <input type="radio" name="color" value="#3a6ea5" checked hidden>
                        </label>
                        <label class="color-swatch" style="background:#6b3fa0;width:28px;height:28px;border-radius:3px;cursor:pointer;border:2px solid transparent">
                            <input type="radio" name="color" value="#6b3fa0" hidden>
                        </label>
                        <label class="color-swatch" style="background:#1e5c32;width:28px;height:28px;border-radius:3px;cursor:pointer;border:2px solid transparent">
                            <input type="radio" name="color" value="#1e5c32" hidden>
                        </label>
                        <label class="color-swatch" style="background:#a5542e;width:28px;height:28px;border-radius:3px;cursor:pointer;border:2px solid transparent">
                            <input type="radio" name="color" value="#a5542e" hidden>
                        </label>
                        <label class="color-swatch" style="background:#8b3a3a;width:28px;height:28px;border-radius:3px;cursor:pointer;border:2px solid transparent">
                            <input type="radio" name="color" value="#8b3a3a" hidden>
                        </label>
                        <label class="color-swatch" style="background:#4a4a4a;width:28px;height:28px;border-radius:3px;cursor:pointer;border:2px solid transparent">
                            <input type="radio" name="color" value="#4a4a4a" hidden>
                        </label>
                        <label class="color-swatch" style="background:#2a6b6b;width:28px;height:28px;border-radius:3px;cursor:pointer;border:2px solid transparent">
                            <input type="radio" name="color" value="#2a6b6b" hidden>
                        </label>
                        <label class="color-swatch" style="background:#6b4a2a;width:28px;height:28px;border-radius:3px;cursor:pointer;border:2px solid transparent">
                            <input type="radio" name="color" value="#6b4a2a" hidden>
                        </label>
                        <label class="color-swatch" style="background:#3a3a6b;width:28px;height:28px;border-radius:3px;cursor:pointer;border:2px solid transparent">
                            <input type="radio" name="color" value="#3a3a6b" hidden>
                        </label>
                    </div>
                </div>
                <div id="server-node-fields" style="margin-top:12px"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Server</button>
            </div>
        </div>
        </form>
    </div>
</div>

<!-- Node Modal -->
<div class="modal fade" id="node-modal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <form id="node-form" onsubmit="return RackBuilder.saveNode(event)">
        <div class="modal-content">
            <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title" id="node-modal-title">Node</h4></div>
            <div class="modal-body">
                <input type="hidden" name="id" id="node-id">
                <input type="hidden" name="server_id" id="node-server-id">
                <input type="hidden" name="node_number" id="node-number">
                <div class="form-group">
                    <label>Label</label>
                    <input type="text" name="label" class="form-control" required maxlength="255">
                </div>
                <div class="form-group">
                    <label>Linked Device</label>
                    <div class="device-search-wrap">
                        <input type="text" class="form-control" id="device-search-input" placeholder="Search LibreNMS devices..." autocomplete="off">
                        <input type="hidden" name="device_id" id="device-id-value">
                        <div class="device-search-results" id="device-search-results"></div>
                    </div>
                    <div id="linked-device-display" style="margin-top:4px;font-size:12px;color:#aaa"></div>
                </div>
                <div class="form-group">
                    <label>Display Name</label>
                    <textarea name="description" class="form-control" rows="2" placeholder="Leave empty to show device name"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Node</button>
            </div>
        </div>
        </form>
    </div>
</div>

<script>
(function() {
    'use strict';

    const API = window.location.pathname.includes('plugin/RackBuilder')
        ? '/plugin/RackBuilder/api'
        : (window.RACKBUILDER_API || '/plugin/RackBuilder/api');

    let state = {
        racks: [],
        currentRackId: null,
        currentRack: null,
        servers: [],
        pollingTimer: null,
        editingServerId: null,
        editingNodeId: null,
        devices: [],
        deviceSearchTimeout: null,
        zoom: 1,
        compactView: localStorage.getItem('rackbuilder_compact') !== 'false',
    };

    function q(sel, ctx) { return (ctx || document).querySelector(sel); }

    function qa(sel, ctx) { return Array.from((ctx || document).querySelectorAll(sel)); }

    function getCsrfToken() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    async function apiFetch(method, path, body) {
        const opts = { method, headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }};
        if (method !== 'GET') {
            opts.headers['X-CSRF-TOKEN'] = getCsrfToken();
        }
        if (body instanceof FormData) {
            opts.body = body;
        } else if (body !== undefined) {
            opts.headers['Content-Type'] = 'application/json';
            opts.body = JSON.stringify(body);
        }
        const resp = await fetch(API + path, opts);
        const data = await resp.json().catch(function() { return {}; });
        var errMsg = data.error || data.message || (resp.status === 422 ? 'Validation error' : 'HTTP ' + resp.status);
        if (!resp.ok) throw new Error(errMsg);
        return data;
    }

    function getRack() { return state.currentRack; }

    function getServers() { return state.servers; }

    // ---- Color picker ----
    qa('.color-swatch').forEach(function(el) {
        el.addEventListener('click', function() {
            qa('.color-swatch').forEach(function(s) { s.style.borderColor = 'transparent'; });
            this.style.borderColor = '#fff';
        });
    });

    // ---- Rack selector ----
    async function loadRacks() {
        try {
            state.racks = await apiFetch('GET', '/racks');
            const sel = q('#rack-selector');
            const val = sel.value;
            sel.innerHTML = '<option value="">-- Select a Rack --</option>';
            state.racks.forEach(function(r) {
                var opt = document.createElement('option');
                opt.value = r.id;
                opt.textContent = r.name + ' (' + r.size + 'U)';
                sel.appendChild(opt);
            });
            var savedId = val || localStorage.getItem('rackbuilder_rack_id');
            if (savedId && state.racks.some(function(r) { return r.id == savedId; })) {
                sel.value = savedId;
                selectRack(savedId);
            }
        } catch (e) { console.error('loadRacks:', e); }
    }

    function selectRack(rackId) {
        if (!rackId) {
            q('#rack-view').style.display = 'none';
            q('#rack-empty').style.display = 'block';
            stopPolling();
            q('#edit-rack-btn').disabled = true;
            q('#delete-rack-btn').disabled = true;
            q('#rack-info').textContent = '';
            state.currentRackId = null;
            state.currentRack = null;
            state.servers = [];
            return;
        }
        state.currentRackId = parseInt(rackId);
        localStorage.setItem('rackbuilder_rack_id', rackId);
        state.currentRack = state.racks.find(function(r) { return r.id == rackId; });
        q('#edit-rack-btn').disabled = false;
        q('#delete-rack-btn').disabled = false;
        q('#rack-info').textContent = state.currentRack.description || '';
        loadRackData(rackId);
    }

    async function loadRackData(rackId) {
        try {
            q('#rack-view').style.display = 'block';
            q('#rack-empty').style.display = 'none';
            q('#rack-grid-wrapper').classList.add('loading');

            var data = await apiFetch('GET', '/racks/' + rackId + '/servers');
            state.servers = data.servers || [];
            renderGrids(state.currentRack, state.servers);
            startPolling(rackId);
        } catch (e) {
            console.error('loadRackData:', e);
            toastr && toastr.error('Failed to load rack data');
        } finally {
            q('#rack-grid-wrapper').classList.remove('loading');
        }
    }

    // ---- Grid rendering ----
    function renderGrids(rack, servers) {
        var size = rack.size;
        var isTelecom = rack.layout === 'telecom';

        // Main rack front/back
        var mainSvr = servers.filter(function(s) { return s.panel === 'main' || !s.panel; });
        renderGrid('front-rack-grid', size, mainSvr.filter(function(s) { return s.side !== 'back'; }), 'front');
        renderGrid('back-rack-grid', size, mainSvr.filter(function(s) { return s.side !== 'front'; }), 'back');

        // Side panels for telecom racks
        var leftPanel = q('#side-left-panel');
        var rightPanel = q('#side-right-panel');
        if (isTelecom) {
            var leftSvr = servers.filter(function(s) { return s.panel === 'side-left'; });
            var rightSvr = servers.filter(function(s) { return s.panel === 'side-right'; });
            renderSidePanel('side-left-grid', leftSvr);
            renderSidePanel('side-right-grid', rightSvr);
            leftPanel.style.display = '';
            rightPanel.style.display = '';
        } else {
            leftPanel.style.display = 'none';
            rightPanel.style.display = 'none';
        }
    }

    function renderSidePanel(gridId, servers) {
        var container = q('#' + gridId);
        if (!container) return;
        var panelId = container.dataset.panel;
        container.innerHTML = '';

        if (state.compactView) {
            // Compact: single column, short rows
            container.style.gridTemplateColumns = '24px 1fr';
            container.style.gridTemplateRows = 'repeat(6, 28px)';
            var occ = {};
            for (var u = 1; u <= 6; u++) occ[u] = null;
            servers.forEach(function(s) {
                for (var u = s.u_position; u < s.u_position + s.u_height; u++) occ[u] = s;
            });
            for (var u = 6; u >= 1; u--) {
                var rowIdx = 6 - u + 1;
                var O = occ[u];
                var lbl = document.createElement('div');
                lbl.className = 'u-label';
                lbl.textContent = 'U' + u;
                lbl.style.gridRow = rowIdx;
                lbl.style.gridColumn = '1';
                container.appendChild(lbl);

                if (O && u === O.u_position) {
                    var tr = 6 - (O.u_position + O.u_height - 1) + 1;
                    var blk = makeSideBlockCompact(O, tr, O.u_height);
                    container.appendChild(blk);
                } else if (!O) {
                    var cel = document.createElement('div');
                    cel.className = 'empty-slot drop-zone';
                    cel.style.gridRow = rowIdx;
                    cel.style.gridColumn = '2';
                    cel.style.cursor = 'pointer';
                    cel.style.display = 'flex';
                    cel.style.alignItems = 'center';
                    cel.style.padding = '0 6px';
                    cel.style.fontSize = '9px';
                    cel.style.color = '#555';
                    cel.textContent = '---';
                    cel.title = 'U' + u;
                    if (u === 3 || u === 5) cel.style.borderTop = '1px solid ' + (detectTheme() === 'dark' ? '#444' : '#ccc');
                    cel.addEventListener('click', (function(p, pp) {
                        return function() { showServerModal(null, p, pp); };
                    })(u, panelId));
                    container.appendChild(cel);
                }
            }
        } else {
            // Full: 2-column, tall rows, vertical text
            container.style.gridTemplateColumns = '1fr 1fr';
            container.style.gridTemplateRows = 'repeat(3, 96px)';

            var occ = {};
            for (var u = 1; u <= 6; u++) occ[u] = null;
            servers.forEach(function(s) {
                for (var u = s.u_position; u < s.u_position + s.u_height; u++) occ[u] = s;
            });

            var groups = [[5,6], [3,4], [1,2]];
            groups.forEach(function(group, gi) {
                var rowIdx = gi + 1;
                var u1 = group[0], u2 = group[1];
                var s1 = occ[u1], s2 = occ[u2];
                if (s1 && s1.u_height === 2 && s1 === s2) {
                    container.appendChild(makeSideBlock(s1, rowIdx, '1 / span 2'));
                } else {
                    if (s1 && u1 === s1.u_position) {
                        container.appendChild(makeSideBlock(s1, rowIdx, '1'));
                    } else if (!occ[u1]) {
                        container.appendChild(makeEmptySideCell(u1, rowIdx, '1', panelId));
                    }
                    if (s2 && u2 === s2.u_position) {
                        container.appendChild(makeSideBlock(s2, rowIdx, '2'));
                    } else if (!occ[u2]) {
                        container.appendChild(makeEmptySideCell(u2, rowIdx, '2', panelId));
                    }
                }
            });
        }
    }

    function makeSideBlock(svr, rowIdx, colSpan) {
        var block = document.createElement('div');
        block.className = 'server-block fade-in drag-server';
        block.draggable = true;
        block.style.gridRow = rowIdx;
        block.style.gridColumn = colSpan;
        block.style.background = svr.color || '#3a6ea5';
        block.dataset.serverId = svr.id;
        block.dataset.u = svr.u_position;
        block.dataset.slot = 'full';

        var txt = document.createElement('div');
        txt.style.cssText = 'writing-mode:vertical-lr;text-orientation:upright;display:flex;align-items:center;justify-content:center;flex:1;font-size:9px;line-height:1;padding:4px 0';
        txt.textContent = svr.name;
        block.appendChild(txt);

        var acts = document.createElement('div');
        acts.className = 'server-actions';
        acts.innerHTML = '<button class="btn btn-xs btn-danger" onclick="event.stopPropagation();RackBuilder.deleteServer(' + svr.id + ')" title="Remove"><i class="fa fa-times"></i></button>';
        block.appendChild(acts);

        block.addEventListener('click', function(e) {
            if (!RackBuilder.wasDragging()) RackBuilder.editServer(svr.id);
        });
        return block;
    }

    function makeSideBlockCompact(svr, topRow, span) {
        var block = document.createElement('div');
        block.className = 'server-block fade-in drag-server';
        block.draggable = true;
        block.style.gridRow = topRow + ' / span ' + span;
        block.style.gridColumn = '2';
        block.style.background = svr.color || '#3a6ea5';
        block.style.flexDirection = 'row';
        block.style.alignItems = 'center';
        block.style.padding = '0 6px';
        block.style.fontSize = '10px';
        block.style.minHeight = '0';
        block.dataset.serverId = svr.id;
        block.dataset.u = svr.u_position;
        block.dataset.slot = 'full';

        var txt = document.createElement('span');
        txt.textContent = svr.name;
        block.appendChild(txt);

        var acts = document.createElement('div');
        acts.className = 'server-actions';
        acts.innerHTML = '<button class="btn btn-xs btn-danger" onclick="event.stopPropagation();RackBuilder.deleteServer(' + svr.id + ')" title="Remove"><i class="fa fa-times"></i></button>';
        block.appendChild(acts);

        block.addEventListener('click', function(e) {
            if (!RackBuilder.wasDragging()) RackBuilder.editServer(svr.id);
        });
        return block;
    }

    function makeEmptySideCell(u, rowIdx, col, panelId) {
        var cell = document.createElement('div');
        cell.className = 'empty-slot drop-zone';
        cell.style.gridRow = rowIdx;
        cell.style.gridColumn = col;
        cell.style.cursor = 'pointer';
        cell.style.display = 'flex';
        cell.style.alignItems = 'center';
        cell.style.justifyContent = 'center';
        cell.title = 'U' + u;

        var label = document.createElement('span');
        label.style.cssText = 'writing-mode:vertical-lr;text-orientation:upright;opacity:0.5;font-size:9px';
        label.textContent = 'U' + u;
        cell.appendChild(label);

        if (u === 2 || u === 4) {
            cell.style.borderBottom = '2px solid ' + (detectTheme() === 'dark' ? '#555' : '#bbb');
        }

        cell.addEventListener('click', (function(p, pp) {
            return function() { showServerModal(null, p, pp); };
        })(u, panelId));
        return cell;
    }

    function buildServerHTML(svr, view) {
        var html = '';
        if (svr.nodes && svr.nodes.length) {
            var rows = svr.u_height;
            var cols = 2;
            html += '<div class="node-grid" style="display:grid;grid-template-columns:1fr 1fr;grid-template-rows:repeat(' + rows + ',1fr);gap:1px;flex:1;min-height:0">';
            svr.nodes.forEach(function(n) {
                var pos = getNodeGridPos(n.node_number, svr.num_nodes, rows, cols, view);
                var bulbClass = n.status_light || 'grey';
                var label = escapeHtml(n.label);
                html += '<div class="node-row" style="grid-row:' + pos.r + '/' + (pos.r + pos.rs) + ';grid-column:' + pos.c + '/' + (pos.c + pos.cs) + ';display:flex;align-items:center;justify-content:center;gap:4px" onclick="event.stopPropagation();RackBuilder.editServer(' + svr.id + ')">';
                var displayName = escapeHtml(n.description || (n.device ? (n.device.display || n.device.hostname) : null) || label);
                html += '<span class="status-bulb ' + bulbClass + '"></span>';
                if (n.device) {
                    html += '<span><a href="/device/' + n.device.device_id + '/" class="device-link" target="_blank" onclick="event.stopPropagation()">' + displayName + '</a></span>';
                } else {
                    html += '<span>' + displayName + '</span>';
                }
                html += '</div>';
            });
            html += '</div>';
        } else {
            html += '<div style="flex:1;display:flex;align-items:center;justify-content:center;font-size:10px;color:rgba(255,255,255,0.35);font-style:italic;cursor:pointer" onclick="event.stopPropagation();RackBuilder.showNodeModal(null,' + svr.id + ')">+ Add node</div>';
        }
        if (view === 'front') {
            html += '<div class="server-actions" style="position:absolute;top:1px;right:2px;z-index:2;display:flex;gap:2px">';
            html += '<button class="btn btn-xs btn-danger" onclick="event.stopPropagation();RackBuilder.deleteServer(' + svr.id + ')" title="Remove"><i class="fa fa-times"></i></button>';
            html += '</div>';
        }
        return html;
    }

    function getNodeGridPos(num, total, rows, cols, view) {
        if (total === 1) return { r:1, c:1, rs:rows, cs:cols };
        if (total === rows * cols) {
            var c = Math.ceil(num / rows);
            var r = ((num - 1) % rows) + 1;
            if (view === 'back') c = cols - c + 1;
            return { r:r, c:c, rs:1, cs:1 };
        }
        if (total === rows) {
            return { r:num, c:1, rs:1, cs:cols };
        }
        return { r:1, c:1, rs:1, cs:cols };
    }

    function renderGrid(containerId, size, servers, view) {
        var container = document.getElementById(containerId);
        container.innerHTML = '';
        var rowH = state.compactView ? 20 : 28;
        container.style.gridTemplateRows = 'repeat(' + size + ', ' + rowH + 'px)';
        container.removeAttribute('data-dragging');

        var sorted = [].concat(servers).sort(function(a, b) { return a.u_position - b.u_position; });

        var occ = {};
        for (var u = 1; u <= size; u++) occ[u] = { full: null, left: null, right: null };

        sorted.forEach(function(s) {
            for (var u = s.u_position; u < s.u_position + s.u_height; u++) {
                if (s.slot_position === 'left') occ[u].left = s;
                else if (s.slot_position === 'right') occ[u].right = s;
                else occ[u].full = s;
            }
        });

        for (var u = size; u >= 1; u--) {
            var rowIdx = size - u + 1;
            var rowStr = rowIdx.toString();

            var label = document.createElement('div');
            label.className = 'u-label';
            label.textContent = 'U' + u;
            label.style.gridRow = rowStr;
            label.dataset.u = u;
            if (state.compactView) {
                label.style.height = rowH + 'px';
                label.style.fontSize = '9px';
                label.style.fontWeight = '600';
            }
            container.appendChild(label);

            var O = occ[u];
            var topFull = (O.full && u === O.full.u_position);
            var topLeft = (O.left && u === O.left.u_position);
            var topRight = (O.right && u === O.right.u_position);

            if (O.full && u === O.full.u_position) {
                var topRow = size - (O.full.u_position + O.full.u_height - 1) + 1;
                var blk = state.compactView
                    ? makeCompactBlock(O.full, topRow, O.full.u_height, view)
                    : makeBlock(O.full, topRow, O.full.u_height, view);
                blk.style.gridColumn = '2 / span 2';
                container.appendChild(blk);
            } else if (!O.full) {
                if (O.left && u === O.left.u_position) {
                    var topRowL = size - (O.left.u_position + O.left.u_height - 1) + 1;
                    var blkL = state.compactView
                        ? makeCompactBlock(O.left, topRowL, O.left.u_height, view)
                        : makeBlock(O.left, topRowL, O.left.u_height, view);
                    blkL.className += ' half-left';
                    blkL.style.gridColumn = '2';
                    container.appendChild(blkL);
                } else if (!O.left) {
                    var leftSlot = document.createElement('div');
                    leftSlot.className = 'empty-slot empty-slot-left drop-zone';
                    leftSlot.style.gridRow = rowStr;
                    leftSlot.style.gridColumn = '2';
                    leftSlot.dataset.u = u;
                    leftSlot.dataset.slot = 'left';
                    leftSlot.title = 'U' + u + ' L';
                    if (state.compactView) leftSlot.style.height = rowH + 'px';
                    if (view === 'front') {
                        leftSlot.style.cursor = 'pointer';
                        leftSlot.addEventListener('click', function(uu) { return function() { RackBuilder.showServerModal(null, uu); }; }(u));
                    }
                    container.appendChild(leftSlot);
                }
                if (O.right && u === O.right.u_position) {
                    var topRowR = size - (O.right.u_position + O.right.u_height - 1) + 1;
                    var blkR = state.compactView
                        ? makeCompactBlock(O.right, topRowR, O.right.u_height, view)
                        : makeBlock(O.right, topRowR, O.right.u_height, view);
                    blkR.className += ' half-right';
                    blkR.style.gridColumn = '3';
                    container.appendChild(blkR);
                } else if (!O.right) {
                    var rightSlot = document.createElement('div');
                    rightSlot.className = 'empty-slot empty-slot-right drop-zone';
                    rightSlot.style.gridRow = rowStr;
                    rightSlot.style.gridColumn = '3';
                    rightSlot.dataset.u = u;
                    rightSlot.dataset.slot = 'right';
                    rightSlot.title = 'U' + u + ' R';
                    if (state.compactView) rightSlot.style.height = rowH + 'px';
                    if (view === 'front') {
                        rightSlot.style.cursor = 'pointer';
                        rightSlot.addEventListener('click', function(uu) { return function() { RackBuilder.showServerModal(null, uu); }; }(u));
                    }
                    container.appendChild(rightSlot);
                }
            }
        }
    }

    function makeBlock(svr, topRow, span, view) {
        var block = document.createElement('div');
        var cls = 'server-block fade-in drag-server';
        if (view === 'back') cls += ' server-block-back';
        block.draggable = true;
        block.className = cls;
        block.style.gridRow = topRow + ' / span ' + span;
        block.style.background = svr.color || '#3a6ea5';
        block.dataset.serverId = svr.id;
        block.dataset.u = svr.u_position;
        block.dataset.slot = svr.slot_position || 'full';
        block.innerHTML = buildServerHTML(svr, view);
        block.addEventListener('click', function(e) {
            if (!RackBuilder.wasDragging()) RackBuilder.editServer(svr.id);
        });
        return block;
    }

    function makeCompactBlock(svr, topRow, span, view) {
        var block = document.createElement('div');
        var cls = 'server-block fade-in drag-server';
        if (view === 'back') cls += ' server-block-back';
        block.draggable = true;
        block.className = cls;
        block.style.gridRow = topRow + ' / span ' + span;
        block.style.background = svr.color || '#3a6ea5';
        block.style.border = 'none';
        block.style.borderRadius = '2px';
        block.style.padding = '1px';
        block.style.minHeight = '0';
        block.innerHTML = buildCompactServerHTML(svr, view);
        block.dataset.serverId = svr.id;
        block.dataset.u = svr.u_position;
        block.dataset.slot = svr.slot_position || 'full';
        block.addEventListener('click', function(e) {
            if (!RackBuilder.wasDragging()) RackBuilder.editServer(svr.id);
        });
        return block;
    }

    function buildCompactServerHTML(svr, view) {
        var html = '';
        if (svr.nodes && svr.nodes.length) {
            var rows = svr.u_height;
            var cols = 2;
            html += '<div class="node-grid" style="display:grid;grid-template-columns:1fr 1fr;grid-template-rows:repeat(' + rows + ',1fr);gap:1px;flex:1;min-height:0">';
            svr.nodes.forEach(function(n) {
                var pos = getNodeGridPos(n.node_number, svr.num_nodes, rows, cols, view);
                var bulbClass = n.status_light || 'grey';
                var label = escapeHtml(n.label);
                html += '<div class="node-row" style="grid-row:' + pos.r + '/' + (pos.r + pos.rs) + ';grid-column:' + pos.c + '/' + (pos.c + pos.cs) + ';display:flex;align-items:center;justify-content:center;gap:2px;padding:0 1px;font-size:9px;font-weight:600" onclick="event.stopPropagation();RackBuilder.editServer(' + svr.id + ')">';
                var displayName = escapeHtml(n.description || (n.device ? (n.device.display || n.device.hostname) : null) || label);
                html += '<span class="status-bulb" style="width:6px;height:6px;border-radius:50%;flex-shrink:0;background:' + getBulbColor(bulbClass) + ';box-shadow:' + (bulbClass === 'green' ? '0 0 4px #5cff5c' : bulbClass === 'red' ? '0 0 4px #ff3333' : bulbClass === 'yellow' ? '0 0 4px #ffee33' : 'none') + '"></span>';
                if (n.device) {
                    html += '<span><a href="/device/' + n.device.device_id + '/" class="device-link" target="_blank" onclick="event.stopPropagation()">' + displayName + '</a></span>';
                } else {
                    html += '<span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-weight:600">' + displayName + '</span>';
                }
                html += '</div>';
            });
            html += '</div>';
        } else {
            html += '<div style="flex:1;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:600;color:rgba(255,255,255,0.3);font-style:italic;cursor:pointer" onclick="event.stopPropagation();RackBuilder.showNodeModal(null,' + svr.id + ')">+</div>';
        }
        if (view === 'front') {
            html += '<div class="server-actions" style="position:absolute;top:0;right:1px;z-index:2">';
            html += '<button class="btn btn-xs btn-danger" onclick="event.stopPropagation();RackBuilder.deleteServer(' + svr.id + ')" title="Remove"><i class="fa fa-times"></i></button>';
            html += '</div>';
        }
        return html;
    }

    function getBulbColor(cls) {
        if (cls === 'green') return '#5cff5c';
        if (cls === 'yellow') return '#ffee33';
        if (cls === 'red') return '#ff3333';
        if (cls === 'black') return '#555';
        return '#444';
    }

    function buildBulbsHTML(svr) {
        if (!svr.nodes || !svr.nodes.length) return '';
        var colors = {};
        svr.nodes.forEach(function(n) {
            var c = n.status_light || 'grey';
            colors[c] = (colors[c] || 0) + 1;
        });
        var html = '';
        var order = ['green','yellow','red','black','grey'];
        order.forEach(function(c) {
            if (colors[c]) {
                for (var i = 0; i < Math.min(colors[c], 4); i++) {
                    html += '<span class="status-bulb ' + c + '"></span>';
                }
            }
        });
        return html + ' ';
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    // ---- Drag and Drop ----
    var dragState = null; // { serverId, height, slot, startU, ghost, previewEl }

    function wasDragging() { return dragState !== null; }

    document.addEventListener('dragstart', function(e) {
        var blk = e.target.closest('.drag-server');
        if (!blk) return;
        var id = parseInt(blk.dataset.serverId);
        var svr = state.servers.find(function(s) { return s.id == id; });
        if (!svr) return;

        dragState = {
            serverId: id,
            height: svr.u_height,
            slot: svr.slot_position || 'full',
            side: svr.side || 'both',
            panel: svr.panel || 'main',
            startU: svr.u_position,
            ghost: null,
            previewEl: null,
        };

        // Custom drag ghost
        var ghost = document.createElement('div');
        ghost.className = 'drag-ghost';
        ghost.textContent = svr.name + ' (' + svr.u_height + 'U)';
        ghost.style.background = svr.color || '#3a6ea5';
        document.body.appendChild(ghost);
        e.dataTransfer.setDragImage(ghost, 0, 0);
        dragState.ghost = ghost;
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/plain', svr.id);

        // Add dragging class to source
        blk.classList.add('dragging');
        document.querySelectorAll('.rack-grid').forEach(function(g) { g.classList.add('drag-active'); });

        setTimeout(function() {
            if (ghost.parentNode) ghost.parentNode.removeChild(ghost);
        }, 100);
    });

    document.addEventListener('dragover', function(e) {
        var grid = e.target.closest('.rack-grid');
        if (!grid || !dragState) return;
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        var targetPanel = grid.dataset.panel || 'main';
        var gridSize = targetPanel === 'main' ? (state.currentRack ? state.currentRack.size : 48) : 6;
        var targetU = getUFromY(e.clientX, e.clientY, grid, gridSize);
        var isSide = targetPanel !== 'main';
        if (isSide && dragState && dragState.height === 2) {
            targetU = targetU <= 2 ? 1 : targetU <= 4 ? 3 : 5;
        }
        if (targetU !== state._dragHoverU) {
            state._dragHoverU = targetU;
            showDropPreview(grid, targetU);
        }
    });

    document.addEventListener('dragleave', function(e) {
        var grid = e.target.closest('.rack-grid');
        if (!grid) state._dragHoverU = null;
    });

    document.addEventListener('drop', function(e) {
        var grid = e.target.closest('.rack-grid');
        if (!grid || !dragState) return;
        e.preventDefault();

        var targetPanel = grid.dataset.panel || 'main';
        var gridSize = targetPanel === 'main' ? (state.currentRack ? state.currentRack.size : 48) : 6;
        var targetU = getUFromY(e.clientX, e.clientY, grid, gridSize);
        state._dragHoverU = null;
        if (!targetU) return;

        var newPos = targetU;
        var isSide = targetPanel !== 'main';
        var newSlot = isSide ? 'full' : dragState.slot;
        var newSide = isSide ? 'both' : dragState.side;
        var newPanel = targetPanel;
        var serverId = dragState.serverId;
        var height = dragState.height;
        var startU = dragState.startU;
        var startPanel = dragState.panel;
        var origSlot = dragState.slot;

        // For side panels with 2U servers, snap to odd positions (1,3,5)
        if (isSide && height === 2) {
            newPos = newPos <= 2 ? 1 : newPos <= 4 ? 3 : 5;
        }

        // Validate bounds
        if (newPos + height - 1 > gridSize) {
            newPos = gridSize - height + 1;
        }
        if (newPos < 1) newPos = 1;

        // Block cross-panel drags
        if (startPanel !== newPanel) {
            removeAllPreviews();
            cleanupDrag();
            toastr && toastr.error('Cannot move server to a different panel');
            return;
        }

        // Check overlap on client side (only same panel)
        var conflict = false;
        state.servers.forEach(function(s) {
            if (s.id === serverId) return;
            if ((s.panel || 'main') !== newPanel) return;
            var sEnd = s.u_position + s.u_height - 1;
            var dEnd = newPos + height - 1;
            if (!(newPos <= sEnd && dEnd >= s.u_position)) return;
            if (newSide !== 'both' && s.side !== 'both' && newSide !== s.side) return;
            if (newSlot === 'full' || s.slot_position === 'full') { conflict = true; }
            else if (newSlot === s.slot_position) { conflict = true; }
        });

        removeAllPreviews();
        cleanupDrag();

        if (conflict) {
            toastr && toastr.error('Position conflicts with an existing server');
            return;
        }

        if (newPos === startU && newSlot === origSlot && newPanel === startPanel) return;

        var svr = state.servers.find(function(s) { return s.id == serverId; });
        if (!svr) return;

        apiFetch('PUT', '/servers/' + serverId, {
            panel: newPanel,
            name: svr.name,
            u_height: svr.u_height,
            u_position: newPos,
            num_nodes: svr.num_nodes,
            slot_position: newSlot,
            side: newSide,
            description: svr.description || '',
            color: svr.color || null,
        }).then(function() {
            loadRackData(state.currentRackId);
        }).catch(function(err) {
            toastr && toastr.error(err.message);
            loadRackData(state.currentRackId);
        });
    });

    document.addEventListener('dragend', function(e) {
        cleanupDrag();
        state._dragHoverU = null;
        document.querySelectorAll('.rack-grid').forEach(function(g) {
            g.classList.remove('drag-active');
        });
        removeAllPreviews();
    });

    function getUFromY(clientX, clientY, grid, rackSize) {
        var rect = grid.getBoundingClientRect();
        var isSide = grid.dataset.panel && grid.dataset.panel !== 'main';

        if (isSide) {
            if (state.compactView) {
                var rowHeight = 28;
                var relY = clientY - rect.top;
                var row = Math.floor(relY / rowHeight) + 1;
                return Math.max(1, Math.min(6, 6 - row + 1));
            } else {
                var relY = clientY - rect.top;
                var grp = Math.floor(relY / 96);
                grp = Math.max(0, Math.min(2, grp));
                var relX = clientX - rect.left;
                var col = relX > rect.width / 2 ? 1 : 0;
                var base = (2 - grp) * 2;
                return base + col + 1;
            }
        } else {
            var rowHeight = state.compactView ? 20 : 28;
            var relativeY = clientY - rect.top;
            var row = Math.floor(relativeY / rowHeight) + 1;
            var u = rackSize - row + 1;
            return Math.max(1, Math.min(rackSize, u));
        }
    }

    function showDropPreview(grid, u) {
        removeAllPreviews();
        var targetPanel = grid.dataset.panel || 'main';
        var gridSize = targetPanel === 'main' ? (state.currentRack ? state.currentRack.size : 48) : 6;
        var isSide = targetPanel !== 'main';
        var slot = isSide ? 'full' : dragState.slot;
        var side = isSide ? 'both' : dragState.side;

        var preview = document.createElement('div');
        preview.className = 'drop-preview';
        if (isSide && state.compactView) {
            var rowIdx = 6 - (u + dragState.height - 1) + 1;
            preview.style.gridRow = rowIdx + ' / span ' + dragState.height;
            preview.style.gridColumn = '2';
        } else if (isSide) {
            var height = dragState.height;
            var grpRow = 4 - Math.ceil(u / 2);
            var uInGroup = ((u - 1) % 2) + 1;
            if (height === 2) {
                preview.style.gridRow = grpRow;
                preview.style.gridColumn = '1 / span 2';
            } else {
                preview.style.gridRow = grpRow;
                preview.style.gridColumn = uInGroup.toString();
            }
        } else {
            var rowIdx = gridSize - (u + dragState.height - 1) + 1;
            preview.style.gridRow = rowIdx + ' / span ' + dragState.height;
            if (slot === 'full') {
            preview.style.gridColumn = '2 / span 2';
        } else if (slot === 'left') {
            preview.style.gridColumn = '2';
        } else if (slot === 'right') {
            preview.style.gridColumn = '3';
        } else {
            preview.style.gridColumn = '2 / span 2';
        }
        }

        var valid = true;
        if (u + dragState.height - 1 > gridSize) valid = false;
        state.servers.forEach(function(s) {
            if (s.id === dragState.serverId) return;
            if ((s.panel || 'main') !== targetPanel) return;
            var sEnd = s.u_position + s.u_height - 1;
            var dEnd = u + dragState.height - 1;
            if (!(u <= sEnd && dEnd >= s.u_position)) return;
            if (side !== 'both' && s.side !== 'both' && side !== s.side) return;
            if (slot === 'full' || s.slot_position === 'full') { valid = false; }
            else if (slot === s.slot_position) { valid = false; }
        });
        if (!valid) preview.classList.add('invalid');

        grid.appendChild(preview);
    }

    function removeAllPreviews() {
        document.querySelectorAll('.drop-preview').forEach(function(p) { p.parentNode.removeChild(p); });
    }

    function cleanupDrag() {
        if (dragState) {
            if (dragState.ghost && dragState.ghost.parentNode) dragState.ghost.parentNode.removeChild(dragState.ghost);
            dragState = null;
        }
        document.querySelectorAll('.drag-server.dragging').forEach(function(b) { b.classList.remove('dragging'); });
    }

    // ---- Status polling ----
    function startPolling(rackId) {
        stopPolling();
        state.pollingTimer = setInterval(function() {
            pollStatus(rackId);
        }, 60000);
    }

    function stopPolling() {
        if (state.pollingTimer) {
            clearInterval(state.pollingTimer);
            state.pollingTimer = null;
        }
    }

    async function pollStatus(rackId) {
        try {
            var data = await apiFetch('GET', '/racks/' + rackId + '/status');
            var bulbs = document.querySelectorAll('.server-block .node-row .status-bulb');
            var nodeMap = {};
            Object.keys(data).forEach(function(nid) {
                nodeMap[nid] = data[nid];
            });
            bulbs.forEach(function(bulb) {
                var row = bulb.closest('.node-row');
                if (!row) return;
                // Find the node id: the row's onclick contains editNode(NODE_ID,...)
                var match = row.getAttribute('onclick') && row.getAttribute('onclick').match(/editNode\((\d+)/);
                if (!match) return;
                var nid = match[1];
                var status = nodeMap[nid];
                if (status) {
                    var newClass = status.status_light || 'grey';
                    ['green','yellow','red','black','grey'].forEach(function(c) {
                        bulb.classList.remove(c);
                    });
                    bulb.classList.add(newClass);
                    bulb.classList.add('pulse');
                    setTimeout(function() { bulb.classList.remove('pulse'); }, 600);
                }
            });
        } catch (e) { /* silent */ }
    }

    // ---- Rack CRUD ----
    function showRackModal(rack) {
        var form = q('#rack-form');
        var title = q('#rack-modal-title');
        if (rack) {
            title.textContent = 'Edit Rack';
            form.querySelector('[name="name"]').value = rack.name;
            form.querySelector('[name="size"]').value = rack.size;
            form.querySelector('[name="layout"]').value = rack.layout || 'standard';
            form.querySelector('[name="description"]').value = rack.description || '';
            form.setAttribute('data-edit-id', rack.id);
        } else {
            title.textContent = 'New Rack';
            form.reset();
            form.querySelector('[name="size"]').value = '42';
            form.querySelector('[name="layout"]').value = 'standard';
            form.removeAttribute('data-edit-id');
        }
        jQuery('#rack-modal').modal('show');
    }

    async function saveRack(event) {
        event.preventDefault();
        var form = q('#rack-form');
        var data = {
            name: form.querySelector('[name="name"]').value,
            size: parseInt(form.querySelector('[name="size"]').value),
            layout: form.querySelector('[name="layout"]').value,
            description: form.querySelector('[name="description"]').value,
        };
        try {
            var editId = form.getAttribute('data-edit-id');
            if (editId) {
                await apiFetch('PUT', '/racks/' + editId, data);
            } else {
                await apiFetch('POST', '/racks', data);
            }
            jQuery('#rack-modal').modal('hide');
            await loadRacks();
            if (editId) {
                q('#rack-selector').value = editId;
                selectRack(editId);
            }
        } catch (e) {
            toastr && toastr.error(e.message);
        }
    }

    async function deleteCurrentRack() {
        if (!state.currentRackId) return;
        if (!confirm('Delete rack "' + (state.currentRack ? state.currentRack.name : '') + '"? All servers will be removed.')) return;
        try {
            await apiFetch('DELETE', '/racks/' + state.currentRackId);
            q('#rack-selector').value = '';
            selectRack('');
            await loadRacks();
        } catch (e) {
            toastr && toastr.error(e.message);
        }
    }

    // ---- Server CRUD ----
    function showServerModal(server, position, panel) {
        var form = q('#server-form');
        var title = q('#server-modal-title');
        form.reset();

        // Show/hide panel group based on rack layout
        var panelGroup = q('#panel-group');
        if (state.currentRack && state.currentRack.layout === 'telecom') {
            panelGroup.style.display = '';
        } else {
            panelGroup.style.display = 'none';
        }

        if (server) {
            title.textContent = 'Edit Server';
            form.querySelector('[name="name"]').value = server.name;
            form.querySelector('[name="panel"]').value = server.panel || 'main';
            form.querySelector('[name="num_nodes"]').value = server.num_nodes;
            form.querySelector('[name="slot_position"]').value = server.slot_position || 'full';
            form.querySelector('[name="side"]').value = server.side || 'both';
            form.querySelector('[name="description"]').value = server.description || '';
            toggleSidePanelFields();
            form.querySelector('[name="u_height"]').value = server.u_height;
            updatePositionOptions();
            if (server.color) {
                var swatch = form.querySelector('input[name="color"][value="' + server.color + '"]');
                if (swatch) {
                    swatch.checked = true;
                    qa('.color-swatch').forEach(function(s) { s.style.borderColor = 'transparent'; });
                    if (swatch.closest) swatch.closest('.color-swatch').style.borderColor = '#fff';
                }
            }
            form.setAttribute('data-edit-id', server.id);
            state.editingServerId = server.id;
            form.querySelector('[name="u_position"]').value = server.u_position;
        } else {
            title.textContent = 'Add Server';
            form.querySelector('[name="num_nodes"]').value = '1';
            form.querySelector('[name="panel"]').value = panel || 'main';
            form.removeAttribute('data-edit-id');
            state.editingServerId = null;
            toggleSidePanelFields();
            if (position) form.querySelector('[name="u_position"]').value = position;
        }
        // Populate inline node fields
        var nodeFields = q('#server-node-fields');
        nodeFields.innerHTML = '';
        if (server && server.nodes && server.nodes.length) {
            var header = document.createElement('h5');
            header.style.cssText = 'margin:0 0 8px 0;font-weight:600';
            header.textContent = 'Nodes';
            nodeFields.appendChild(header);
            server.nodes.forEach(function(n) {
                var wrap = document.createElement('div');
                wrap.style.cssText = 'margin-bottom:10px;padding:8px;background:rgba(255,255,255,0.04);border-radius:4px;border:1px solid rgba(255,255,255,0.06)';
                wrap.innerHTML = '<div style="font-size:11px;font-weight:600;margin-bottom:4px">' + escapeHtml(n.label) + '</div>';
                var nid = n.id;
                // Label
                var lblInput = document.createElement('input');
                lblInput.type = 'text';
                lblInput.className = 'form-control input-sm';
                lblInput.value = n.label || '';
                lblInput.placeholder = 'Label';
                lblInput.style.cssText = 'font-size:11px;height:26px;margin-bottom:4px';
                wrap.appendChild(lblInput);
                // Device
                var devInput = document.createElement('input');
                devInput.type = 'text';
                devInput.className = 'form-control input-sm';
                devInput.value = n.device ? (n.device.display || n.device.hostname) : '';
                devInput.placeholder = 'Search LibreNMS devices...';
                devInput.style.cssText = 'font-size:11px;height:26px;margin-bottom:4px';
                devInput.dataset.deviceId = n.device ? n.device.device_id : '';
                wrap.appendChild(devInput);
                // Description
                var descInput = document.createElement('input');
                descInput.type = 'text';
                descInput.className = 'form-control input-sm';
                descInput.value = n.description || '';
                descInput.placeholder = 'Overrides device name on rack';
                descInput.style.cssText = 'font-size:11px;height:26px;margin-bottom:4px';
                wrap.appendChild(descInput);
                // Save button
                var saveBtn = document.createElement('button');
                saveBtn.type = 'button';
                saveBtn.className = 'btn btn-xs btn-primary';
                saveBtn.innerHTML = '<i class="fa fa-check"></i> Save Node';
                saveBtn.style.cssText = 'font-size:10px';
                saveBtn.onclick = function() { saveInlineNode(nid, lblInput, devInput, descInput); };
                wrap.appendChild(saveBtn);
                nodeFields.appendChild(wrap);
                // Device search on input
                devInput.addEventListener('input', function() {
                    clearTimeout(this._st);
                    var inp = this;
                    inp.dataset.deviceId = '';
                    inp._st = setTimeout(function() { searchDevices(inp.value, function(devices) { showDeviceDropdown(inp, devices); }); }, 300);
                });
                devInput.addEventListener('blur', function() {
                    setTimeout(function() { var dd = devInput.parentNode.querySelector('.inline-dd'); if (dd) dd.style.display = 'none'; }, 200);
                });
            });
        }
        jQuery('#server-modal').modal('show');
    }

    function updatePositionOptions() {
        var panel = q('#server-form').querySelector('[name="panel"]');
        var panelVal = panel ? panel.value : 'main';
        var isSide = panelVal !== 'main';
        var height = parseInt(q('#server-height').value);
        var rack = state.currentRack;
        if (!rack) return;
        var prevVal = q('#server-position').value;
        var maxSize = (isSide && state.currentRack.layout === 'telecom') ? 6 : rack.size;
        var maxPos = maxSize - height + 1;
        if (maxPos < 1) maxPos = 1;
        var sel = q('#server-position');
        sel.innerHTML = '';
        if (isSide) {
            if (height === 2) {
                [1, 3, 5].forEach(function(p) {
                    var opt = document.createElement('option');
                    opt.value = p;
                    opt.textContent = 'U' + p + '-U' + (p + 1) + ' (Group ' + ((p + 1) / 2) + ')';
                    sel.appendChild(opt);
                });
            } else {
                for (var i = 1; i <= maxPos; i++) {
                    var opt = document.createElement('option');
                    opt.value = i;
                    opt.textContent = 'U' + i + ' (Group ' + (i <= 2 ? 1 : i <= 4 ? 2 : 3) + ')';
                    sel.appendChild(opt);
                }
            }
        } else {
            for (var i = 1; i <= maxPos; i++) {
                var opt = document.createElement('option');
                opt.value = i;
                opt.textContent = 'U' + i + ' - U' + (i + height - 1);
                sel.appendChild(opt);
            }
        }
        if (prevVal && parseInt(prevVal) <= maxPos) sel.value = prevVal;
    }

    function toggleSidePanelFields() {
        var panel = q('#server-form').querySelector('[name="panel"]');
        var panelVal = panel ? panel.value : 'main';
        var isSide = panelVal !== 'main';
        var heightSel = q('#server-height');
        var widthGroup = q('[name="slot_position"]').closest('.form-group');
        var sideGroup = q('[name="side"]').closest('.form-group');
        if (isSide) {
            q('[name="slot_position"]').value = 'full';
            q('[name="side"]').value = 'both';
            if (widthGroup) widthGroup.style.display = 'none';
            if (sideGroup) sideGroup.style.display = 'none';
            // Limit height to 1U/2U for side panels
            heightSel.innerHTML = '';
            [1, 2].forEach(function(h) {
                var opt = document.createElement('option');
                opt.value = h;
                opt.textContent = h + 'U';
                heightSel.appendChild(opt);
            });
            heightSel.value = '1';
        } else {
            if (widthGroup) widthGroup.style.display = '';
            if (sideGroup) sideGroup.style.display = '';
            // Restore full height options
            heightSel.innerHTML = '';
            [1,2,3,4,5,6,7,8].forEach(function(h) {
                var opt = document.createElement('option');
                opt.value = h;
                opt.textContent = h + 'U';
                heightSel.appendChild(opt);
            });
            heightSel.value = '1';
        }
        updatePositionOptions();
    }

    function onPanelChange() {
        toggleSidePanelFields();
    }

    async function saveServer(event) {
        event.preventDefault();
        if (!state.currentRackId) return;
        var form = q('#server-form');
        var panelField = form.querySelector('[name="panel"]');
        var panelVal = panelField ? panelField.value : 'main';
        var isSide = panelVal !== 'main';
        var data = {
            rack_id: state.currentRackId,
            panel: panelVal,
            name: form.querySelector('[name="name"]').value,
            u_height: parseInt(form.querySelector('[name="u_height"]').value),
            u_position: parseInt(form.querySelector('[name="u_position"]').value),
            num_nodes: parseInt(form.querySelector('[name="num_nodes"]').value),
            slot_position: isSide ? 'full' : form.querySelector('[name="slot_position"]').value,
            side: isSide ? 'both' : form.querySelector('[name="side"]').value,
            description: form.querySelector('[name="description"]').value,
            color: (form.querySelector('[name="color"]:checked') || {}).value || null,
        };
        try {
            var editId = form.getAttribute('data-edit-id');
            if (editId) {
                await apiFetch('PUT', '/servers/' + editId, data);
            } else {
                await apiFetch('POST', '/servers', data);
            }
            jQuery('#server-modal').modal('hide');
            await loadRackData(state.currentRackId);
        } catch (e) {
            toastr && toastr.error(e.message);
        }
    }

    function editServer(serverId) {
        var svr = state.servers.find(function(s) { return s.id == serverId; });
        if (svr) showServerModal(svr);
    }

    async function deleteServer(serverId) {
        if (!confirm('Remove this server from the rack?')) return;
        try {
            await apiFetch('DELETE', '/servers/' + serverId);
            await loadRackData(state.currentRackId);
        } catch (e) {
            toastr && toastr.error(e.message);
        }
    }

    // ---- Inline node save ----
    async function saveInlineNode(nodeId, lblInput, devInput, descInput) {
        try {
            await apiFetch('PUT', '/nodes/' + nodeId, {
                label: lblInput.value,
                device_id: devInput.dataset.deviceId ? parseInt(devInput.dataset.deviceId) : null,
                description: descInput.value,
            });
            toastr && toastr.success('Node saved');
        } catch (e) {
            toastr && toastr.error(e.message);
        }
    }

    async function searchDevices(query, callback) {
        if (query.trim().length < 2) { callback([]); return; }
        try {
            callback(await apiFetch('GET', '/devices/search?q=' + encodeURIComponent(query)));
        } catch (e) { callback([]); }
    }

    function showDeviceDropdown(input, devices) {
        var existing = input.parentNode.querySelector('.inline-dd');
        if (existing) existing.parentNode.removeChild(existing);
        if (!devices.length) return;
        var dd = document.createElement('div');
        dd.className = 'inline-dd';
        dd.style.cssText = 'position:absolute;z-index:1060;top:100%;left:0;right:0;max-height:150px;overflow-y:auto;background:#2d2d2d;border:1px solid #555;border-radius:0 0 3px 3px';
        devices.forEach(function(d) {
            var item = document.createElement('div');
            item.style.cssText = 'padding:3px 8px;cursor:pointer;font-size:11px;display:flex;align-items:center;gap:6px';
            item.innerHTML = '<span class="status-bulb ' + (d.status_light || 'grey') + '"></span>' + escapeHtml(d.text);
            item.onmouseenter = function() { item.style.background = 'rgba(255,255,255,0.08)'; };
            item.onmouseleave = function() { item.style.background = ''; };
            item.onclick = function() {
                input.value = d.text;
                input.dataset.deviceId = d.id;
                dd.style.display = 'none';
            };
            dd.appendChild(item);
        });
        input.parentNode.style.position = 'relative';
        input.parentNode.appendChild(dd);
    }

    // ---- Node CRUD ----
    function showNodeModal(node, serverId) {
        var form = q('#node-form');
        var title = q('#node-modal-title');

        if (node) {
            var parentSvr = state.servers.find(function(s) { return s.id == node.server_id; });
            title.textContent = 'Edit Node' + (parentSvr ? ' - ' + parentSvr.name : '');
            form.querySelector('[name="id"]').value = node.id;
            form.querySelector('[name="server_id"]').value = node.server_id;
            form.querySelector('[name="node_number"]').value = node.node_number;
            form.querySelector('[name="label"]').value = node.label || '';
            form.querySelector('[name="description"]').value = node.description || '';
            if (node.device) {
                form.querySelector('[name="device_id"]').value = node.device.device_id;
                q('#device-search-input').value = node.device.display || node.device.hostname;
                q('#linked-device-display').innerHTML = '<span class="status-bulb ' + (node.status_light || 'grey') + '"></span> <a href="/device/' + node.device.device_id + '/" class="device-link" target="_blank">' + escapeHtml(node.device.display || node.device.hostname) + '</a>';
            } else {
                form.querySelector('[name="device_id"]').value = '';
                q('#device-search-input').value = '';
                q('#linked-device-display').innerHTML = '';
            }
            form.setAttribute('data-edit-id', node.id);
            state.editingNodeId = node.id;
        } else {
            title.textContent = 'Add Node';
            form.reset();
            form.querySelector('[name="server_id"]').value = serverId;
            // find next available node_number
            var svr = state.servers.find(function(s) { return s.id == serverId; });
            var existingNums = (svr && svr.nodes || []).map(function(n) { return n.node_number; });
            var nextNum = 1;
            while (existingNums.indexOf(nextNum) >= 0) nextNum++;
            form.querySelector('[name="node_number"]').value = nextNum;
            q('#device-search-input').value = '';
            q('#linked-device-display').innerHTML = '';
            form.removeAttribute('data-edit-id');
            state.editingNodeId = null;
        }
        jQuery('#node-modal').modal('show');
    }

    function editNode(nodeId, svrId) {
        var svr = state.servers.find(function(s) { return s.id == svrId; });
        if (!svr) return;
        var node = (svr.nodes || []).find(function(n) { return n.id == nodeId; });
        if (node) showNodeModal(node);
    }

    async function saveNode(event) {
        event.preventDefault();
        var form = q('#node-form');
        var data = {
            server_id: parseInt(form.querySelector('[name="server_id"]').value),
            node_number: parseInt(form.querySelector('[name="node_number"]').value),
            label: form.querySelector('[name="label"]').value,
            device_id: form.querySelector('[name="device_id"]').value || null,
            description: form.querySelector('[name="description"]').value,
        };
        if (data.device_id) data.device_id = parseInt(data.device_id);

        try {
            var editId = form.getAttribute('data-edit-id');
            if (editId) {
                await apiFetch('PUT', '/nodes/' + editId, data);
            } else {
                await apiFetch('POST', '/nodes', data);
            }
            jQuery('#node-modal').modal('hide');
            await loadRackData(state.currentRackId);
        } catch (e) {
            toastr && toastr.error(e.message);
        }
    }

    // ---- Device search ----
    q('#device-search-input').addEventListener('input', function() {
        clearTimeout(state.deviceSearchTimeout);
        q('#device-id-value').value = '';
        q('#linked-device-display').innerHTML = '';
        var q = this.value.trim();
        if (q.length < 2) {
            q('#device-search-results').style.display = 'none';
            return;
        }
        state.deviceSearchTimeout = setTimeout(function() {
            performDeviceSearch(q);
        }, 300);
    });

    async function performDeviceSearch(query) {
        try {
            var data = await apiFetch('GET', '/devices/search?q=' + encodeURIComponent(query));
            var res = q('#device-search-results');
            res.innerHTML = '';
            if (!data.length) {
                res.style.display = 'none';
                return;
            }
            data.forEach(function(d) {
                var item = document.createElement('div');
                item.className = 'ds-item';
                var bulb = '<span class="status-bulb ' + (d.status_light || 'grey') + '"></span>';
                var name = '<span class="ds-name">' + escapeHtml(d.text) + '</span>';
                item.innerHTML = bulb + name;
                item.addEventListener('click', function() {
                    selectDevice(d.id, d.text, d.status_light || 'grey');
                });
                res.appendChild(item);
            });
            res.style.display = 'block';
        } catch (e) { /* silent */ }
    }

    function selectDevice(id, name, statusLight) {
        q('#device-id-value').value = id;
        q('#device-search-input').value = name;
        q('#device-search-results').style.display = 'none';
        q('#linked-device-display').innerHTML = '<span class="status-bulb ' + statusLight + '"></span> <a href="/device/' + id + '/" class="device-link" target="_blank">' + escapeHtml(name) + '</a>';
    }

    q('#device-search-input').addEventListener('blur', function() {
        setTimeout(function() {
            q('#device-search-results').style.display = 'none';
        }, 200);
    });

    // ---- Zoom ----
    function applyZoom() {
        var wrapper = q('#rack-grid-wrapper');
        if (!wrapper) return;
        wrapper.style.transform = 'scale(' + state.zoom + ')';
        wrapper.style.transformOrigin = 'top left';
        q('#zoom-label').textContent = Math.round(state.zoom * 100) + '%';
    }
    function zoomIn() { state.zoom = Math.min(state.zoom + 0.1, 2); applyZoom(); }
    function zoomOut() { state.zoom = Math.max(state.zoom - 0.1, 0.4); applyZoom(); }
    function zoomReset() { state.zoom = 1; applyZoom(); }

    function detectTheme() {
        return document.documentElement.classList.contains('dark') ? 'dark' : 'light';
    }
    function applyTheme() {
        var th = detectTheme();
        q('#rack-builder').setAttribute('data-rack-theme', th);
    }

    function printRack() {
        var front = q('#front-rack-grid');
        var back = q('#back-rack-grid');
        if (!front || !back) return;

        var isDark = detectTheme() === 'dark';
        var html = '<!DOCTYPE html><html><head><style>';
        html += '@page { size: portrait; margin: 3mm; }';
        html += '* { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }';
        html += 'body { margin:0;padding:3mm;background:#fff; }';
        html += '.pw { display:flex;gap:6px;align-items:flex-start; }';
        html += '.pp { flex:1;min-width:0; }';
        html += 'h4 { text-align:center;margin:0 0 3px;font-size:10px;' + (isDark ? '' : 'color:#333;') + ' }';
        html += '.pg { display:grid;grid-template-columns:20px 1fr 1fr;gap:1px;background:' + (isDark ? '#2d2d2d' : '#d0d0d0') + ';border:1px solid ' + (isDark ? '#555' : '#bbb') + ';border-radius:2px;padding:1px; }';
        html += '.ul { display:flex;align-items:center;justify-content:center;font-size:7px;color:' + (isDark ? '#aaa' : '#555') + ';background:' + (isDark ? '#1e1e1e' : '#e8e8e8') + ';height:22px; }';
        html += '.es { background:' + (isDark ? '#2a2a2a' : '#f5f5f5') + ';height:22px;border:1px dashed ' + (isDark ? '#3a3a3a' : '#ccc') + '; }';
        html += '.sb { position:relative;border:1px solid rgba(255,255,255,0.15);border-radius:1px;padding:0;display:flex;flex-direction:column;min-height:22px; }';
        html += '.ng { display:grid;grid-template-columns:1fr 1fr;gap:1px;flex:1;min-height:0; }';
        html += '.nr { font-size:7px;color:' + (isDark ? 'rgba(255,255,255,0.85)' : 'rgba(0,0,0,0.75)') + ';display:flex;align-items:center;justify-content:center;gap:2px;background:' + (isDark ? 'rgba(0,0,0,0.12)' : 'rgba(255,255,255,0.5)') + ';border-radius:1px;padding:0; }';
        html += '.sbk { opacity:1;border-style:dashed; }';
        html += '.bulb { display:inline-block;width:6px;height:6px;border-radius:50%;flex-shrink:0; }';
        html += '.bg{background:#5cff5c}.by{background:#ffee33}.br{background:#ff3333}.bb{background:#555}.bg2{background:#444;border:1px solid #666}';
        html += '.sg { display:grid;grid-template-columns:1fr;gap:1px;background:' + (isDark ? '#2d2d2d' : '#d0d0d0') + ';border:1px solid ' + (isDark ? '#555' : '#bbb') + ';border-radius:2px;padding:1px; }';
        html += '</style></head><body><div class="pw">';

        var rackSize = state.currentRack ? state.currentRack.size : 48;
        var isTelecom = state.currentRack && state.currentRack.layout === 'telecom';

        // Side panels for telecom racks (2-column layout)
        if (isTelecom) {
            var sideCSS = 'display:grid;grid-template-columns:1fr 1fr;gap:1px;background:' + (isDark ? '#2d2d2d' : '#d0d0d0') + ';border:1px solid ' + (isDark ? '#555' : '#bbb') + ';border-radius:2px;padding:1px;';
            ['side-left','side-right'].forEach(function(panelId) {
                var label = panelId === 'side-left' ? 'Side L' : 'Side R';
                var svrs = state.servers.filter(function(s) { return s.panel === panelId; });
                html += '<div class="pp"><h4>' + label + '</h4><div class="pg" style="' + sideCSS + 'grid-template-rows:repeat(3,22px)">';
                var occ = {};
                for (var pu = 1; pu <= 6; pu++) occ[pu] = null;
                svrs.forEach(function(s) {
                    for (var pu = s.u_position; pu < s.u_position + s.u_height; pu++) {
                        occ[pu] = s;
                    }
                });
                var pg = [[5,6],[3,4],[1,2]];
                pg.forEach(function(g, gi) {
                    var ri = gi + 1;
                    var u1 = g[0], u2 = g[1];
                    var s1 = occ[u1], s2 = occ[u2];
                    if (s1 && s1.u_height === 2 && s1 === s2) {
                        html += '<div class="sb" style="grid-row:' + ri + ';grid-column:1/span 2;background:' + (s1.color || '#3a6ea5') + '">';
                        html += buildPrintNodes(s1, 'both');
                        html += '</div>';
                    } else {
                        if (s1 && u1 === s1.u_position) {
                            html += '<div class="sb" style="grid-row:' + ri + ';grid-column:1;background:' + (s1.color || '#3a6ea5') + '">';
                            html += buildPrintNodes(s1, 'both');
                            html += '</div>';
                        } else if (!occ[u1]) {
                            html += '<div class="es" style="grid-row:' + ri + ';grid-column:1"></div>';
                        }
                        if (s2 && u2 === s2.u_position) {
                            html += '<div class="sb" style="grid-row:' + ri + ';grid-column:2;background:' + (s2.color || '#3a6ea5') + '">';
                            html += buildPrintNodes(s2, 'both');
                            html += '</div>';
                        } else if (!occ[u2]) {
                            html += '<div class="es" style="grid-row:' + ri + ';grid-column:2"></div>';
                        }
                    }
                });
                html += '</div></div>';
            });
        }

        ['front','back'].forEach(function(view) {
            html += '<div class="pp"><h4>' + (view === 'front' ? 'Front' : 'Back') + '</h4><div class="pg" style="grid-template-rows:repeat(' + rackSize + ',22px)">';

            var occ = {};
            for (var u = 1; u <= rackSize; u++) occ[u] = { full: null, left: null, right: null };
            var svrs = state.servers.filter(function(s) {
                if (isTelecom && s.panel && s.panel !== 'main') return false;
                return view === 'front' ? s.side !== 'back' : s.side !== 'front';
            }).sort(function(a,b) { return a.u_position - b.u_position; });
            svrs.forEach(function(s) {
                for (var u = s.u_position; u < s.u_position + s.u_height; u++) {
                    if (s.slot_position === 'left') occ[u].left = s;
                    else if (s.slot_position === 'right') occ[u].right = s;
                    else occ[u].full = s;
                }
            });

            for (var u = rackSize; u >= 1; u--) {
                var row = rackSize - u + 1;
                html += '<div class="ul" style="grid-row:' + row + '">U' + u + '</div>';
                var O = occ[u];
                if (O.full && u === O.full.u_position) {
                    var tr = rackSize - (O.full.u_position + O.full.u_height - 1) + 1;
                    var c = O.full.color || '#3a6ea5';
                    html += '<div class="sb" style="grid-row:' + tr + '/span ' + O.full.u_height + ';grid-column:2/span 2;background:' + c + '">';
                    html += buildPrintNodes(O.full, view);
                    html += '</div>';
                } else if (!O.full) {
                    if (O.left && u === O.left.u_position) {
                        var tr = rackSize - (O.left.u_position + O.left.u_height - 1) + 1;
                        var c = O.left.color || '#3a6ea5';
                        html += '<div class="sb" style="grid-row:' + tr + '/span ' + O.left.u_height + ';grid-column:2;background:' + c + '">';
                        html += buildPrintNodes(O.left, view);
                        html += '</div>';
                    } else if (!O.left) {
                        html += '<div class="es" style="grid-row:' + row + ';grid-column:2"></div>';
                    }
                    if (O.right && u === O.right.u_position) {
                        var tr = rackSize - (O.right.u_position + O.right.u_height - 1) + 1;
                        var c = O.right.color || '#3a6ea5';
                        html += '<div class="sb sbk" style="grid-row:' + tr + '/span ' + O.right.u_height + ';grid-column:3;background:' + c + '">';
                        html += buildPrintNodes(O.right, view);
                        html += '</div>';
                    } else if (!O.right) {
                        html += '<div class="es" style="grid-row:' + row + ';grid-column:3"></div>';
                    }
                }
            }
            html += '</div></div>';
        });

        html += '</div></body></html>';

        var w = window.open('', '_blank', 'width=1200,height=800');
        w.document.write(html);
        w.document.close();
        w.focus();
        setTimeout(function() { w.print(); }, 500);
    }

    function buildPrintNodes(svr, view) {
        if (!svr.nodes || !svr.nodes.length) return '';
        var rows = svr.u_height;
        var html = '<div class="ng" style="grid-template-rows:repeat(' + rows + ',1fr)">';
        svr.nodes.forEach(function(n) {
            var pos = getNodeGridPos(n.node_number, svr.num_nodes, rows, 2, view);
            var bulb = 'bg2';
            if (n.status_light === 'green') bulb = 'bg';
            else if (n.status_light === 'yellow') bulb = 'by';
            else if (n.status_light === 'red') bulb = 'br';
            else if (n.status_light === 'black') bulb = 'bb';
            var displayName = escapeHtml(n.description || (n.device ? (n.device.display || n.device.hostname) : null) || n.label);
            html += '<div class="nr" style="grid-row:' + pos.r + '/' + (pos.r+pos.rs) + ';grid-column:' + pos.c + '/' + (pos.c+pos.cs) + '"><span class="bulb ' + bulb + '"></span>' + displayName + '</div>';
        });
        html += '</div>';
        return html;
    }

    // ---- Compact view toggle ----
    function toggleCompactView() {
        state.compactView = !state.compactView;
        localStorage.setItem('rackbuilder_compact', state.compactView);
        var btn = q('#compact-toggle-btn');
        if (btn) {
            if (state.compactView) {
                btn.className = 'btn btn-sm btn-primary';
                btn.title = 'Switch to normal view';
            } else {
                btn.className = 'btn btn-sm btn-default';
                btn.title = 'Toggle compact view';
            }
        }
        if (state.currentRackId) loadRackData(state.currentRackId);
    }

    // ---- Init ----
    loadRacks();
    applyTheme();

    // Sync compact toggle button with default state
    (function() {
        var btn = q('#compact-toggle-btn');
        if (btn) {
            if (state.compactView) {
                btn.className = 'btn btn-sm btn-primary';
                btn.title = 'Switch to normal view';
            } else {
                btn.className = 'btn btn-sm btn-default';
                btn.title = 'Toggle compact view';
            }
        }
    })();

    // Watch for LibreNMS theme changes
    var themeObserver = new MutationObserver(function() { applyTheme(); });
    themeObserver.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

    // Expose to global
    window.RackBuilder = {
        zoomIn: zoomIn,
        zoomOut: zoomOut,
        zoomReset: zoomReset,
        printRack: printRack,
        state: state,
        selectRack: selectRack,
        showRackModal: showRackModal,
        saveRack: saveRack,
        deleteCurrentRack: deleteCurrentRack,
        showServerModal: showServerModal,
        saveServer: saveServer,
        editServer: editServer,
        deleteServer: deleteServer,
        showNodeModal: showNodeModal,
        editNode: editNode,
        saveNode: saveNode,
        updatePositionOptions: updatePositionOptions,
        onPanelChange: onPanelChange,
        toggleSidePanelFields: toggleSidePanelFields,
        loadRackData: loadRackData,
        wasDragging: wasDragging,
        saveInlineNode: saveInlineNode,
        applyTheme: applyTheme,
        toggleCompactView: toggleCompactView,
    };
})();
</script>
