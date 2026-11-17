<style id="rb-styles">
/* ===================================================================
   RackBuilder — all rules are scoped to #rack-builder
   =================================================================== */
#rack-builder {
    --u-h: 28px;
    --rail: 26px;
    --side-h: 100px;
    --node-font: 10px;

    --rb-text: #e6e8eb;
    --rb-muted: #8b929c;
    --rb-surface: #1f232a;
    --rb-surface-2: #272c34;
    --rb-border: #363c45;
    --rb-accent: #4c9be8;
    --rb-hover: rgba(76, 155, 232, .16);

    --rb-cab: #1a1d22;
    --rb-cab-edge: #0e1013;
    --rb-rail: #2b3038;
    --rb-rail-text: #858d98;
    --rb-slot: #20242a;
    --rb-slot-line: rgba(255, 255, 255, .04);

    color: var(--rb-text);
}
#rack-builder.is-compact { --u-h: 20px; --side-h: 76px; --node-font: 9px; }

#rack-builder[data-rack-theme="light"] {
    --rb-text: #1f2328;
    --rb-muted: #67707a;
    --rb-surface: #f6f8fa;
    --rb-surface-2: #ffffff;
    --rb-border: #d5dbe1;
    --rb-accent: #2f80d1;
    --rb-hover: rgba(47, 128, 209, .12);

    --rb-cab: #aeb6c0;
    --rb-cab-edge: #8f98a3;
    --rb-rail: #c8ced6;
    --rb-rail-text: #4a525c;
    --rb-slot: #e9edf1;
    --rb-slot-line: rgba(0, 0, 0, .05);
}

#rack-builder [hidden] { display: none !important; }

/* read-only mode for non-admin users */
#rack-builder.is-readonly [data-admin],
#rack-builder.is-readonly .rb-actions,
#rack-builder.is-readonly .rb-addnode { display: none !important; }
#rack-builder.is-readonly .rb-empty,
#rack-builder.is-readonly .rb-server,
#rack-builder.is-readonly .rb-node { cursor: default; }
#rack-builder.is-readonly .rb-empty::after { display: none; }
#rack-builder.is-readonly .rb-empty:hover { background: var(--rb-slot); }
#rack-builder.is-readonly .rb-node:hover { background: rgba(0,0,0,.22); }

/* ---------- header / toolbar ---------- */
#rack-builder .rb-head { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 14px; }
#rack-builder .rb-title { margin: 0; font-size: 18px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
#rack-builder .rb-title i { color: var(--rb-accent); }
#rack-builder .rb-rackpick { display: flex; align-items: center; gap: 6px; margin-left: auto; flex-wrap: wrap; }
#rack-builder .rb-rackpick select { width: auto; min-width: 240px; }

#rack-builder .rb-bar {
    display: flex; flex-wrap: wrap; align-items: center; gap: 10px 18px;
    padding: 10px 14px; margin-bottom: 18px;
    background: var(--rb-surface); border: 1px solid var(--rb-border); border-radius: 8px;
}
#rack-builder .rb-rackname { font-size: 15px; font-weight: 600; line-height: 1.2; }
#rack-builder .rb-rackmeta { font-size: 12px; color: var(--rb-muted); }
#rack-builder .rb-stats { display: flex; flex-wrap: wrap; align-items: center; gap: 6px; }
#rack-builder .rb-chip {
    display: inline-flex; align-items: center; gap: 6px; padding: 3px 10px;
    border-radius: 999px; font-size: 12px; line-height: 18px; color: var(--rb-text);
    background: var(--rb-surface-2); border: 1px solid var(--rb-border);
}
#rack-builder .rb-chip b { font-variant-numeric: tabular-nums; }
#rack-builder .rb-chip.is-zero { opacity: .45; }
#rack-builder .rb-meter { width: 64px; height: 6px; border-radius: 3px; background: var(--rb-border); overflow: hidden; }
#rack-builder .rb-meter i { display: block; height: 100%; background: var(--rb-accent); border-radius: 3px; }
#rack-builder .rb-tools { display: flex; align-items: center; gap: 6px; margin-left: auto; flex-wrap: wrap; }
#rack-builder .rb-zoom-label {
    min-width: 46px; font-size: 12px; text-align: center; color: var(--rb-muted);
    font-variant-numeric: tabular-nums; cursor: pointer; user-select: none;
}

/* ---------- empty states ---------- */
#rack-builder .rb-empty-state { text-align: center; padding: 70px 20px; color: var(--rb-muted); }
#rack-builder .rb-empty-state i { font-size: 48px; opacity: .45; }
#rack-builder .rb-empty-state h4 { margin: 16px 0 6px; color: var(--rb-text); }
#rack-builder .rb-empty-state p { margin-bottom: 16px; }

/* ---------- rack layout ---------- */
#rack-builder .rb-view { overflow: auto; }
#rack-builder .rb-wrapper {
    display: flex; gap: 20px; align-items: flex-start; justify-content: center;
    padding: 4px 4px 14px; transition: opacity .2s;
}
#rack-builder .rb-wrapper.is-loading { opacity: .45; pointer-events: none; }
#rack-builder .rb-face { flex: 1 1 0; min-width: 288px; max-width: 598px; } /* 15% wider than 250/520 */
#rack-builder .rb-face-side { flex: 0 0 100px; min-width: 0; }
#rack-builder.is-compact .rb-face-side { flex-basis: 120px; }
#rack-builder .rb-face-title {
    margin-bottom: 6px; text-align: center; font-size: 11px; font-weight: 700;
    letter-spacing: .14em; text-transform: uppercase; color: var(--rb-muted);
}

/* cabinet frame with little feet */
#rack-builder .rb-cabinet {
    position: relative; padding: 12px 6px; margin-bottom: 8px; border-radius: 6px;
    background: linear-gradient(180deg, var(--rb-cab), var(--rb-cab-edge));
    box-shadow: inset 0 0 0 1px rgba(255,255,255,.06), 0 8px 22px rgba(0,0,0,.28);
}
#rack-builder .rb-cabinet::after {
    content: ''; position: absolute; left: 14px; right: 14px; bottom: -6px; height: 6px;
    background: linear-gradient(90deg, var(--rb-cab-edge) 0 22px, transparent 22px calc(100% - 22px), var(--rb-cab-edge) calc(100% - 22px));
    border-radius: 0 0 3px 3px;
}

#rack-builder .rb-grid { display: grid; gap: 1px; position: relative; }
#rack-builder .rb-main { grid-template-columns: var(--rail) 1fr 1fr var(--rail); }
#rack-builder .rb-side-compact { grid-template-columns: var(--rail) 1fr; grid-template-rows: repeat(6, var(--u-h)); }
#rack-builder .rb-side-full { grid-template-columns: 1fr 1fr; grid-template-rows: repeat(3, var(--side-h)); gap: 3px 2px; }

/* U number rails */
#rack-builder .rb-u {
    display: flex; align-items: center; justify-content: center;
    background: var(--rb-rail); color: var(--rb-rail-text);
    font: 600 9px/1 ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
    user-select: none;
}
#rack-builder .rb-u.is-major { color: var(--rb-text); }
#rack-builder .rb-u-left { border-radius: 2px 0 0 2px; }
#rack-builder .rb-u-right { border-radius: 0 2px 2px 0; }

/* empty slots */
#rack-builder .rb-empty {
    position: relative; background: var(--rb-slot);
    box-shadow: inset 0 -1px 0 var(--rb-slot-line);
    cursor: pointer; transition: background .12s;
}
#rack-builder .rb-empty::after {
    content: '+'; position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;
    color: var(--rb-accent); font-weight: 700; font-size: 13px; opacity: 0; transition: opacity .12s;
}
#rack-builder .rb-empty:hover { background: var(--rb-hover); }
#rack-builder .rb-empty:hover::after { opacity: 1; }
#rack-builder.is-dragging .rb-empty::after { display: none; }
#rack-builder .rb-side-full .rb-empty { border-radius: 3px; }
#rack-builder .rb-side-full .rb-empty::before {
    content: attr(data-label); position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;
    writing-mode: vertical-rl; font-size: 9px; font-weight: 600; color: var(--rb-muted); opacity: .6;
}
#rack-builder .rb-side-full .rb-empty:hover::before { opacity: 0; }

/* server faces */
#rack-builder .rb-server {
    position: relative; display: flex; min-width: 0; min-height: 0; overflow: hidden;
    padding: 2px 9px; border-radius: 3px; color: #fff; cursor: grab;
    background-color: var(--srv, #3a6ea5);
    background-image: linear-gradient(180deg, rgba(255,255,255,.16), rgba(255,255,255,0) 45%, rgba(0,0,0,.2));
    box-shadow: inset 0 0 0 1px rgba(255,255,255,.14), inset 0 -1px 0 rgba(0,0,0,.35), 0 1px 2px rgba(0,0,0,.45);
    animation: rb-in .22s ease-out;
}
#rack-builder .rb-server:active { cursor: grabbing; }
/* rack ears */
#rack-builder .rb-server::before,
#rack-builder .rb-server::after {
    content: ''; position: absolute; top: 3px; bottom: 3px; width: 3px; border-radius: 1px;
    background: repeating-linear-gradient(180deg, rgba(0,0,0,.4) 0 2px, transparent 2px 5px);
}
#rack-builder .rb-server::before { left: 3px; }
#rack-builder .rb-server::after { right: 3px; }
#rack-builder .rb-server-half { padding: 2px 4px; }
#rack-builder .rb-server-half::before,
#rack-builder .rb-server-half::after { display: none; }
/* rear: fan grille + slightly dimmer */
#rack-builder .rb-server-back {
    background-image:
        repeating-linear-gradient(90deg, rgba(0,0,0,.14) 0 2px, transparent 2px 5px),
        linear-gradient(180deg, rgba(255,255,255,.1), rgba(0,0,0,.25));
    filter: saturate(.8) brightness(.92);
}
#rack-builder .rb-server.is-dragging { opacity: .3; }
#rack-builder.no-anim .rb-server { animation: none; }

/* nodes inside a server */
#rack-builder .rb-nodes { flex: 1; display: grid; gap: 2px; min-width: 0; min-height: 0; }
#rack-builder .rb-node {
    display: flex; align-items: center; justify-content: center; gap: 5px; min-width: 0; min-height: 0; padding: 0 6px;
    border-radius: 2px; background: rgba(0,0,0,.22); cursor: pointer;
    font-size: var(--node-font); font-weight: 600; line-height: 1.1;
    text-shadow: 0 1px 1px rgba(0,0,0,.35); transition: background .12s;
}
#rack-builder .rb-node:hover { background: rgba(0,0,0,.38); }
#rack-builder .rb-node-name { min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
#rack-builder .rb-devlink { color: inherit !important; text-decoration: none !important; }
#rack-builder .rb-devlink:hover { text-decoration: underline !important; }
#rack-builder .rb-addnode {
    flex: 1; border: 0; background: transparent; color: rgba(255,255,255,.55);
    font-size: var(--node-font); font-style: italic;
}
#rack-builder .rb-addnode:hover { color: #fff; }

/* side panel servers */
#rack-builder .rb-side-full .rb-server { padding: 4px 2px; justify-content: center; }
#rack-builder .rb-side-full .rb-server::before,
#rack-builder .rb-side-full .rb-server::after { display: none; }
#rack-builder .rb-side-label {
    display: flex; align-items: center; gap: 5px; min-width: 0; min-height: 0; max-height: 100%; overflow: hidden;
    font-size: var(--node-font); font-weight: 600; white-space: nowrap; text-overflow: ellipsis;
    text-shadow: 0 1px 1px rgba(0,0,0,.35);
}
#rack-builder .rb-side-full .rb-side-label { writing-mode: vertical-rl; transform: rotate(180deg); margin: auto; }
#rack-builder .rb-side-compact .rb-server { justify-content: center; }
#rack-builder .rb-side-compact .rb-side-label { align-self: center; }

/* hover actions */
#rack-builder .rb-actions {
    position: absolute; top: 50%; right: 7px; z-index: 3; transform: translateY(-50%);
    display: flex; gap: 2px; opacity: 0; transition: opacity .12s;
}
#rack-builder .rb-server:hover .rb-actions,
#rack-builder .rb-server:focus-within .rb-actions { opacity: 1; }
#rack-builder .rb-side-full .rb-actions { top: 4px; right: 2px; transform: none; flex-direction: column; }
#rack-builder .rb-actions button {
    display: grid; place-items: center; width: 20px; height: 18px; padding: 0;
    border: 0; border-radius: 3px; background: rgba(0,0,0,.6); color: #fff; font-size: 10px;
}
#rack-builder.is-compact .rb-actions button { width: 18px; height: 16px; font-size: 9px; }
#rack-builder .rb-actions button:hover { background: rgba(0,0,0,.85); }
#rack-builder .rb-actions .rb-act-del:hover { background: #c9302c; }

/* status LEDs */
#rack-builder .rb-led {
    flex: none; display: inline-block; width: 7px; height: 7px; border-radius: 50%;
    background: #5b6068; box-shadow: inset 0 0 0 1px rgba(0,0,0,.35);
}
#rack-builder .rb-led.led-green { background: #3ddc84; box-shadow: 0 0 5px 1px rgba(61,220,132,.65); }
#rack-builder .rb-led.led-yellow { background: #ffd23f; box-shadow: 0 0 5px 1px rgba(255,210,63,.6); }
#rack-builder .rb-led.led-red { background: #ff4d4d; box-shadow: 0 0 6px 1px rgba(255,77,77,.75); animation: rb-blink 1.1s steps(2, start) infinite; }
#rack-builder .rb-led.led-black { background: #2b2f35; box-shadow: inset 0 0 0 1px rgba(255,255,255,.3); }
#rack-builder .rb-led.led-grey { background: transparent; box-shadow: inset 0 0 0 1.5px currentColor; opacity: .55; }
#rack-builder .rb-led.is-changed { animation: rb-pop .6s ease-out; }

/* drag & drop */
#rack-builder .rb-drop {
    pointer-events: none; z-index: 5; border-radius: 3px;
    border: 2px dashed var(--rb-accent); background: rgba(76,155,232,.2);
}
#rack-builder .rb-drop.is-invalid { border-color: #ff4d4d; background: rgba(255,77,77,.2); }
.rb-ghost {
    position: fixed; top: -1000px; left: -1000px; padding: 6px 12px; border-radius: 4px;
    color: #fff; font: 600 12px/1.2 sans-serif; white-space: nowrap; box-shadow: 0 8px 24px rgba(0,0,0,.4);
}

/* ---------- modals ---------- */
#rack-builder .rb-modal .modal-body { padding-bottom: 6px; }
#rack-builder .rb-modal label { font-weight: 600; font-size: 12px; }
#rack-builder .rb-section-title {
    margin: 6px 0 10px; padding-top: 12px; border-top: 1px solid var(--rb-border);
    font-size: 11px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--rb-muted);
}
#rack-builder .rb-hint { font-size: 11px; color: var(--rb-muted); margin-top: 4px; }
#rack-builder .rb-swatches { display: flex; flex-wrap: wrap; gap: 8px; }
#rack-builder .rb-swatch { position: relative; margin: 0; cursor: pointer; }
#rack-builder .rb-swatch input { position: absolute; opacity: 0; pointer-events: none; }
#rack-builder .rb-swatch span {
    display: block; width: 26px; height: 26px; border-radius: 6px;
    box-shadow: inset 0 0 0 1px rgba(0,0,0,.25); transition: transform .1s;
}
#rack-builder .rb-swatch:hover span { transform: scale(1.08); }
#rack-builder .rb-swatch input:checked + span { box-shadow: 0 0 0 2px var(--rb-surface-2), 0 0 0 4px var(--rb-accent); }
#rack-builder .rb-swatch input:focus-visible + span { outline: 2px solid var(--rb-accent); outline-offset: 3px; }
#rack-builder .rb-nodecard {
    padding: 10px 12px 4px; margin-bottom: 8px; border-radius: 6px;
    background: var(--rb-surface); border: 1px solid var(--rb-border);
}
#rack-builder .rb-nodecard-title { display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; margin-bottom: 8px; }
#rack-builder .rb-nodecard .form-group { margin-bottom: 8px; }
#rack-builder .modal-footer .rb-footer-left { float: left; }

/* device search */
#rack-builder .rb-ds { position: relative; }
#rack-builder .rb-ds-list {
    position: absolute; top: calc(100% + 2px); left: 0; right: 0; z-index: 1070; display: none;
    max-height: 230px; overflow-y: auto; padding: 4px;
    background: var(--rb-surface-2); border: 1px solid var(--rb-border); border-radius: 6px;
    box-shadow: 0 10px 26px rgba(0,0,0,.3);
}
#rack-builder .rb-ds-list.is-open { display: block; }
#rack-builder .rb-ds-item {
    display: flex; align-items: center; gap: 8px; padding: 6px 8px; border-radius: 4px;
    cursor: pointer; font-size: 13px; color: var(--rb-text);
}
#rack-builder .rb-ds-item small { margin-left: auto; color: var(--rb-muted); font-size: 11px; }
#rack-builder .rb-ds-item:hover,
#rack-builder .rb-ds-item.is-active { background: var(--rb-hover); }
#rack-builder .rb-ds-empty { padding: 6px 8px; font-size: 12px; color: var(--rb-muted); }
#rack-builder .rb-linked { display: flex; align-items: center; gap: 6px; margin-top: 6px; font-size: 12px; }
#rack-builder .rb-linked a { color: var(--rb-accent); }
#rack-builder .rb-linked .btn-link { padding: 0 4px; font-size: 11px; color: var(--rb-muted); }

/* ---------- animation ---------- */
@keyframes rb-in { from { opacity: 0; transform: translateY(3px); } to { opacity: 1; transform: none; } }
@keyframes rb-blink { to { opacity: .35; } }
@keyframes rb-pop { 0% { transform: scale(1); } 40% { transform: scale(1.9); } 100% { transform: scale(1); } }
@media (prefers-reduced-motion: reduce) {
    #rack-builder .rb-server, #rack-builder .rb-led { animation: none !important; }
}

/* ---------- direct browser print (the Print button uses its own window) ---------- */
@media print {
    #rack-builder .rb-head, #rack-builder .rb-tools, #rack-builder .rb-actions,
    #rack-builder .rb-drop, #rack-builder .modal { display: none !important; }
    #rack-builder .rb-view { overflow: visible; }
    #rack-builder .rb-wrapper { zoom: 1 !important; }
    #rack-builder * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
}
</style>

<div id="rack-builder" class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-body">

            <!-- Header -->
            <div class="rb-head">
                <h3 class="rb-title"><i class="fa fa-server"></i> RackBuilder</h3>
                <div class="rb-rackpick">
                    <select id="rb-rack-select" class="form-control input-sm" aria-label="Select rack">
                        <option value="">Select a rack…</option>
                    </select>
                    <div class="btn-group" data-admin>
                        <button type="button" class="btn btn-sm btn-primary" data-action="new-rack"><i class="fa fa-plus"></i> New rack</button>
                        <button type="button" class="btn btn-sm btn-default" data-action="edit-rack" id="rb-edit-rack" disabled title="Edit rack"><i class="fa fa-pencil"></i></button>
                        <button type="button" class="btn btn-sm btn-default" data-action="delete-rack" id="rb-delete-rack" disabled title="Delete rack"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
            </div>

            <!-- Rack view -->
            <div id="rb-rack" hidden>
                <div class="rb-bar">
                    <div>
                        <div class="rb-rackname" id="rb-rack-name"></div>
                        <div class="rb-rackmeta" id="rb-rack-meta"></div>
                    </div>
                    <div class="rb-stats" id="rb-stats"></div>
                    <div class="rb-tools">
                        <button type="button" class="btn btn-sm btn-success" data-action="add-server" data-admin><i class="fa fa-plus"></i> Add server</button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-default" data-action="zoom-out" title="Zoom out"><i class="fa fa-search-minus"></i></button>
                            <span class="btn btn-sm btn-default rb-zoom-label" id="rb-zoom-label" data-action="zoom-reset" title="Reset zoom">100%</span>
                            <button type="button" class="btn btn-sm btn-default" data-action="zoom-in" title="Zoom in"><i class="fa fa-search-plus"></i></button>
                            <button type="button" class="btn btn-sm btn-default" data-action="zoom-fit" title="Fit to screen"><i class="fa fa-arrows-alt"></i></button>
                        </div>
                        <button type="button" class="btn btn-sm btn-default" id="rb-compact-btn" data-action="compact" title="Compact view"><i class="fa fa-compress"></i></button>
                        <button type="button" class="btn btn-sm btn-default" data-action="print" title="Print"><i class="fa fa-print"></i></button>
                    </div>
                </div>

                <div class="rb-view" id="rb-view">
                    <div class="rb-wrapper" id="rb-wrapper">
                        <section class="rb-face rb-face-side" id="rb-side-left-face" hidden>
                            <div class="rb-face-title">Side L</div>
                            <div class="rb-cabinet"><div class="rb-grid" id="rb-side-left" data-panel="side-left" data-view="front"></div></div>
                        </section>
                        <section class="rb-face">
                            <div class="rb-face-title">Front</div>
                            <div class="rb-cabinet"><div class="rb-grid rb-main" id="rb-front" data-panel="main" data-view="front"></div></div>
                        </section>
                        <section class="rb-face">
                            <div class="rb-face-title">Rear</div>
                            <div class="rb-cabinet"><div class="rb-grid rb-main" id="rb-back" data-panel="main" data-view="back"></div></div>
                        </section>
                        <section class="rb-face rb-face-side" id="rb-side-right-face" hidden>
                            <div class="rb-face-title">Side R</div>
                            <div class="rb-cabinet"><div class="rb-grid" id="rb-side-right" data-panel="side-right" data-view="front"></div></div>
                        </section>
                    </div>
                </div>
            </div>

            <!-- Empty state -->
            <div class="rb-empty-state" id="rb-empty" hidden>
                <i class="fa fa-server"></i>
                <h4 id="rb-empty-title">No rack selected</h4>
                <p id="rb-empty-text">Pick a rack from the list above, or create a new one.</p>
                <button type="button" class="btn btn-primary" data-action="new-rack" data-admin><i class="fa fa-plus"></i> New rack</button>
            </div>
        </div>
    </div>

    <!-- Rack modal -->
    <div class="modal fade rb-modal" id="rb-rack-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <form id="rb-rack-form" class="modal-content" novalidate>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    <h4 class="modal-title" id="rb-rack-title">New rack</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rb-rack-name-input">Name</label>
                        <input type="text" id="rb-rack-name-input" name="name" class="form-control" required maxlength="255" placeholder="e.g. DC1 · Row B · Rack 04">
                    </div>
                    <div class="row">
                        <div class="col-xs-6 form-group">
                            <label>Size</label>
                            <select name="size" class="form-control">
                                <option value="42">42U</option>
                                <option value="48">48U</option>
                            </select>
                        </div>
                        <div class="col-xs-6 form-group">
                            <label>Layout</label>
                            <select name="layout" class="form-control">
                                <option value="standard">Standard</option>
                                <option value="telecom">Telecom</option>
                            </select>
                        </div>
                    </div>
                    <div class="rb-hint" style="margin:-8px 0 12px">Telecom racks add 6U side panels on the left and right.</div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Location, owner, notes…"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Server modal -->
    <div class="modal fade rb-modal" id="rb-server-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="rb-server-form" class="modal-content" novalidate>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    <h4 class="modal-title" id="rb-server-title">Add server</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-8 form-group">
                            <label for="rb-server-name">Name</label>
                            <input type="text" id="rb-server-name" name="name" class="form-control" required maxlength="255">
                        </div>
                        <div class="col-sm-4 form-group" id="rb-panel-group">
                            <label>Panel</label>
                            <select name="panel" class="form-control">
                                <option value="main">Main rack</option>
                                <option value="side-left">Side left</option>
                                <option value="side-right">Side right</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 form-group">
                            <label>Height</label>
                            <select name="u_height" class="form-control"></select>
                        </div>
                        <div class="col-sm-5 form-group">
                            <label>Position</label>
                            <select name="u_position" class="form-control"></select>
                        </div>
                        <div class="col-sm-4 form-group">
                            <label>Nodes</label>
                            <select name="num_nodes" class="form-control">
                                <option value="1">1 (standalone)</option>
                                <option value="2">2 nodes</option>
                                <option value="4">4 nodes</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" id="rb-main-only">
                        <div class="col-sm-6 form-group">
                            <label>Width</label>
                            <select name="slot_position" class="form-control">
                                <option value="full">Full width</option>
                                <option value="left">Left half</option>
                                <option value="right">Right half</option>
                            </select>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label>Mounted on</label>
                            <select name="side" class="form-control">
                                <option value="both">Front &amp; rear</option>
                                <option value="front">Front only</option>
                                <option value="back">Rear only</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Colour</label>
                        <div class="rb-swatches" id="rb-swatches"></div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                    <div id="rb-node-editors"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger rb-footer-left" data-action="delete-server-modal" id="rb-server-delete"><i class="fa fa-trash"></i> Remove</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save server</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Node modal -->
    <div class="modal fade rb-modal" id="rb-node-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <form id="rb-node-form" class="modal-content" novalidate>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    <h4 class="modal-title" id="rb-node-title">Node</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rb-node-label">Label</label>
                        <input type="text" id="rb-node-label" name="label" class="form-control" required maxlength="255">
                    </div>
                    <div class="form-group">
                        <label>Linked device</label>
                        <div class="rb-ds">
                            <input type="text" class="form-control" id="rb-node-device" placeholder="Search LibreNMS devices…" autocomplete="off">
                        </div>
                        <div class="rb-linked" id="rb-node-linked"></div>
                    </div>
                    <div class="form-group">
                        <label>Display name</label>
                        <input type="text" name="description" class="form-control" placeholder="Leave empty to show the device name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save node</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
(function () {
    'use strict';

    // ------------------------------------------------------------------
    // Config
    // ------------------------------------------------------------------
    var API = new URL(@json(url('plugin/RackBuilder/api')), window.location.href).pathname.replace(/\/$/, '');
    var DEVICE_URL = new URL(@json(url('device')), window.location.href).pathname.replace(/\/$/, '');
    // UI convenience only — the API enforces this with the `can:admin` middleware.
    var CAN_EDIT = @json((bool) optional(auth()->user())->can('admin'));
    var WRITE_ACTIONS = ['new-rack', 'edit-rack', 'delete-rack', 'add-server', 'add', 'edit-server',
                         'delete-server', 'add-node', 'edit-node', 'delete-server-modal', 'unlink-device'];
    var SIDE_SIZE = 6;
    var POLL_MS = 60000;
    var PALETTE = ['#3a6ea5', '#2d5f8b', '#3a3a6b', '#6b3fa0', '#9c2f5e', '#8b3a3a',
                   '#a5542e', '#b08a2e', '#6b4a2a', '#1e5c32', '#2a6b6b', '#4a4a4a'];
    var STATUS = {
        green:  { label: 'Up' },
        yellow: { label: 'Rebooted < 24h' },
        red:    { label: 'Down' },
        black:  { label: 'Disabled / ignored' },
        grey:   { label: 'Not linked' }
    };
    var STATUS_ORDER = ['red', 'yellow', 'green', 'black', 'grey'];

    var root = document.getElementById('rack-builder');
    function $(sel, ctx) { return (ctx || root).querySelector(sel); }
    function $$(sel, ctx) { return Array.prototype.slice.call((ctx || root).querySelectorAll(sel)); }

    var store = {
        get: function (k, d) { try { var v = localStorage.getItem(k); return v === null ? d : v; } catch (e) { return d; } },
        set: function (k, v) { try { localStorage.setItem(k, v); } catch (e) { /* ignore */ } }
    };

    var state = {
        racks: [],
        rack: null,
        servers: [],
        loadSeq: 0,
        pollTimer: null,
        drag: null,
        editingServer: null,
        editingNode: null,
        editingNodeServer: null,
        nodeDeviceId: null,
        zoom: parseFloat(store.get('rackbuilder_zoom', '1')) || 1,
        compact: store.get('rackbuilder_compact', 'true') !== 'false'
    };

    // ------------------------------------------------------------------
    // Utilities
    // ------------------------------------------------------------------
    function esc(str) {
        if (str === null || str === undefined) return '';
        return String(str).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    function notify(type, msg) {
        if (window.toastr && typeof window.toastr[type] === 'function') window.toastr[type](msg);
        else if (type === 'error') window.alert(msg);
    }

    function csrf() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    async function api(method, path, body) {
        var opts = {
            method: method,
            credentials: 'same-origin',
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        };
        if (method !== 'GET') opts.headers['X-CSRF-TOKEN'] = csrf();
        if (body !== undefined) {
            opts.headers['Content-Type'] = 'application/json';
            opts.body = JSON.stringify(body);
        }
        var resp = await fetch(API + path, opts);
        var data = await resp.json().catch(function () { return {}; });
        if (!resp.ok) {
            var firstErr = data.errors ? Object.values(data.errors)[0] : null;
            throw new Error(data.error || (firstErr && firstErr[0]) || data.message || ('HTTP ' + resp.status));
        }
        return data;
    }

    function setBusy(btn, busy) {
        if (!btn) return;
        btn.disabled = busy;
        if (busy) { btn.dataset.html = btn.innerHTML; btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> ' + btn.textContent.trim(); }
        else if (btn.dataset.html) { btn.innerHTML = btn.dataset.html; }
    }

    function fmtUptime(sec) {
        sec = parseInt(sec, 10);
        if (!sec) return '';
        var d = Math.floor(sec / 86400), h = Math.floor(sec % 86400 / 3600), m = Math.floor(sec % 3600 / 60);
        return d ? d + 'd ' + h + 'h' : h ? h + 'h ' + m + 'm' : m + 'm';
    }

    function led(status, extra) {
        status = STATUS[status] ? status : 'grey';
        return '<span class="rb-led led-' + status + (extra ? ' ' + extra : '') + '" title="' + STATUS[status].label + '"></span>';
    }

    function modal(id, action) { window.jQuery('#' + id).modal(action); }

    function slotOf(s) { return s.slot_position || 'full'; }
    function panelOf(s) { return s.panel || 'main'; }
    function sideOf(s) { return s.side || 'both'; }
    function findServer(id) { return state.servers.find(function (s) { return s.id === +id; }); }
    function panelSize(panel) { return panel === 'main' ? (state.rack ? state.rack.size : 42) : SIDE_SIZE; }

    function worstStatus(nodes) {
        var seen = {};
        (nodes || []).forEach(function (n) { seen[n.status_light || 'grey'] = true; });
        return STATUS_ORDER.find(function (s) { return seen[s]; }) || 'grey';
    }

    function nodeName(n) {
        return n.description || (n.device ? (n.device.display || n.device.hostname) : '') || n.label || ('Node ' + n.node_number);
    }

    // Can a server of this shape be placed here without colliding? (mirrors the server-side check)
    function canPlace(excludeId, panel, u, h, slot, side) {
        if (u < 1 || u + h - 1 > panelSize(panel)) return false;
        return !state.servers.some(function (s) {
            if (s.id === excludeId || panelOf(s) !== panel) return false;
            if (u > s.u_position + s.u_height - 1 || u + h - 1 < s.u_position) return false;
            if (side !== 'both' && sideOf(s) !== 'both' && side !== sideOf(s)) return false;
            return slot === 'full' || slotOf(s) === 'full' || slot === slotOf(s);
        });
    }

    // ------------------------------------------------------------------
    // Racks
    // ------------------------------------------------------------------
    async function loadRacks(selectId) {
        try {
            state.racks = await api('GET', '/racks');
        } catch (e) {
            notify('error', 'Failed to load racks: ' + e.message);
            return;
        }
        var sel = $('#rb-rack-select');
        sel.innerHTML = '<option value="">Select a rack…</option>' + state.racks.map(function (r) {
            var count = r.servers_count !== undefined ? ' · ' + r.servers_count + ' srv' : '';
            return '<option value="' + r.id + '">' + esc(r.name) + ' (' + r.size + 'U' + count + ')</option>';
        }).join('');

        var want = selectId || (state.rack && state.rack.id) || store.get('rackbuilder_rack_id', '');
        var exists = state.racks.some(function (r) { return String(r.id) === String(want); });
        if (!exists && state.racks.length === 1) { want = state.racks[0].id; exists = true; }
        sel.value = exists ? want : '';
        selectRack(exists ? want : '');
    }

    function selectRack(id) {
        var rack = state.racks.find(function (r) { return String(r.id) === String(id); }) || null;
        state.rack = rack;
        $('#rb-edit-rack').disabled = !rack;
        $('#rb-delete-rack').disabled = !rack;
        $('#rb-rack').hidden = !rack;
        $('#rb-empty').hidden = !!rack;

        if (!rack) {
            stopPolling();
            state.servers = [];
            var none = !state.racks.length;
            $('#rb-empty-title').textContent = none ? 'No racks yet' : 'No rack selected';
            $('#rb-empty-text').textContent = !CAN_EDIT
                ? (none ? 'Ask an administrator to create one.' : 'Pick a rack from the list above.')
                : (none ? 'Create your first rack to start laying out servers.' : 'Pick a rack from the list above, or create a new one.');
            return;
        }

        store.set('rackbuilder_rack_id', rack.id);
        $('#rb-rack-name').textContent = rack.name;
        $('#rb-rack-meta').textContent = rack.size + 'U · ' + (rack.layout === 'telecom' ? 'Telecom' : 'Standard') +
            (rack.description ? ' · ' + rack.description : '');
        loadRackData(true);
    }

    async function loadRackData(animate) {
        if (!state.rack) return;
        var seq = ++state.loadSeq;
        var rackId = state.rack.id;
        var wrapper = $('#rb-wrapper');
        wrapper.classList.add('is-loading');
        try {
            var data = await api('GET', '/racks/' + rackId + '/servers');
            if (seq !== state.loadSeq) return; // a newer load superseded this one
            state.servers = data.servers || [];
            renderRack(animate);
            startPolling();
        } catch (e) {
            notify('error', 'Failed to load rack: ' + e.message);
        } finally {
            if (seq === state.loadSeq) wrapper.classList.remove('is-loading');
        }
    }

    function showRackModal(rack) {
        var f = $('#rb-rack-form');
        f.reset();
        $('#rb-rack-title').textContent = rack ? 'Edit rack' : 'New rack';
        f.dataset.editId = rack ? rack.id : '';
        if (rack) {
            f.elements.name.value = rack.name;
            f.elements.size.value = rack.size;
            f.elements.layout.value = rack.layout || 'standard';
            f.elements.description.value = rack.description || '';
        }
        modal('rb-rack-modal', 'show');
    }

    async function saveRack(e) {
        e.preventDefault();
        var f = e.target;
        if (!f.elements.name.value.trim()) { f.elements.name.focus(); return; }
        var btn = f.querySelector('[type=submit]');
        var data = {
            name: f.elements.name.value.trim(),
            size: parseInt(f.elements.size.value, 10),
            layout: f.elements.layout.value,
            description: f.elements.description.value
        };
        setBusy(btn, true);
        try {
            var editId = f.dataset.editId;
            var saved = editId ? await api('PUT', '/racks/' + editId, data) : await api('POST', '/racks', data);
            modal('rb-rack-modal', 'hide');
            notify('success', editId ? 'Rack updated' : 'Rack created');
            await loadRacks(saved.id);
        } catch (err) {
            notify('error', err.message);
        } finally {
            setBusy(btn, false);
        }
    }

    async function deleteRack() {
        if (!state.rack) return;
        if (!window.confirm('Delete rack "' + state.rack.name + '" and all of its servers?')) return;
        try {
            await api('DELETE', '/racks/' + state.rack.id);
            state.rack = null;
            notify('success', 'Rack deleted');
            await loadRacks('');
        } catch (e) {
            notify('error', e.message);
        }
    }

    // ------------------------------------------------------------------
    // Rendering
    // ------------------------------------------------------------------
    function renderRack(animate) {
        var rack = state.rack;
        if (!rack) return;
        root.classList.toggle('no-anim', !animate);

        var main = state.servers.filter(function (s) { return panelOf(s) === 'main'; });
        renderMain($('#rb-front'), rack.size, main.filter(function (s) { return sideOf(s) !== 'back'; }), 'front');
        renderMain($('#rb-back'), rack.size, main.filter(function (s) { return sideOf(s) !== 'front'; }), 'back');

        var telecom = rack.layout === 'telecom';
        ['left', 'right'].forEach(function (k) {
            $('#rb-side-' + k + '-face').hidden = !telecom;
            if (telecom) {
                renderSide($('#rb-side-' + k), state.servers.filter(function (s) { return s.panel === 'side-' + k; }));
            }
        });
        renderStats();
    }

    // Column for a half-width slot. The rear view is mirrored: the front-left half is on the right from behind.
    function halfColumn(slot, view) {
        var left = view === 'back' ? 3 : 2;
        return String(slot === 'left' ? left : 5 - left);
    }

    function renderMain(grid, size, servers, view) {
        grid.style.gridTemplateRows = 'repeat(' + size + ', var(--u-h))';

        var occ = [];
        for (var u = 1; u <= size; u++) occ[u] = { full: null, left: null, right: null };
        servers.forEach(function (s) {
            for (var i = s.u_position; i < s.u_position + s.u_height; i++) {
                if (occ[i]) occ[i][slotOf(s)] = s;
            }
        });

        var html = '';
        for (u = size; u >= 1; u--) {
            var row = size - u + 1;
            var major = u % 5 === 0 ? ' is-major' : '';
            html += '<div class="rb-u rb-u-left' + major + '" style="grid-area:' + row + '/1">' + u + '</div>';
            html += '<div class="rb-u rb-u-right' + major + '" style="grid-area:' + row + '/4">' + u + '</div>';

            var o = occ[u];
            if (o.full) {
                if (u === o.full.u_position) html += serverHTML(o.full, view, topRow(o.full, size), '2 / span 2', false);
                continue;
            }
            ['left', 'right'].forEach(function (half) {
                var s = o[half], col = halfColumn(half, view);
                if (s) {
                    if (u === s.u_position) html += serverHTML(s, view, topRow(s, size), col, true);
                } else {
                    html += '<div class="rb-empty" data-action="add" data-panel="main" data-u="' + u + '" data-slot="' + half +
                        '" style="grid-area:' + row + '/' + col + '" title="U' + u + ' · ' + half + ' half"></div>';
                }
            });
        }
        grid.innerHTML = html;
    }

    function topRow(s, size) { return size - (s.u_position + s.u_height - 1) + 1; }

    function nodeLayout(total, uHeight) {
        if (total <= 1) return { rows: 1, cols: 1 };
        if (total <= uHeight) return { rows: total, cols: 1 };        // stacked sleds
        var cols = uHeight >= 2 ? 2 : total;                           // side by side
        return { rows: Math.ceil(total / cols), cols: cols };
    }

    function nodePos(num, L, view) {
        var c = Math.min(L.cols, Math.ceil(num / L.rows));
        var r = ((num - 1) % L.rows) + 1;
        if (view === 'back') c = L.cols - c + 1;
        return { r: r, c: c };
    }

    function nodeTitle(n) {
        var t = [n.label];
        if (n.device) {
            t.push('Device: ' + n.device.hostname);
            var st = STATUS[n.status_light] ? STATUS[n.status_light].label : '';
            var up = n.device.status ? fmtUptime(n.device.uptime) : '';
            t.push('Status: ' + st + (up ? ' · up ' + up : ''));
        } else {
            t.push('No device linked — click to link one');
        }
        return t.join('\n');
    }

    function serverHTML(s, view, row, col, half) {
        var cls = 'rb-server' + (view === 'back' ? ' rb-server-back' : '') + (half ? ' rb-server-half' : '');
        var title = s.name + ' · ' + s.u_height + 'U @ U' + s.u_position + (s.description ? '\n' + s.description : '');
        var html = '<div class="' + cls + '" draggable="true" data-action="edit-server" data-server-id="' + s.id + '"' +
            ' style="grid-row:' + row + ' / span ' + s.u_height + ';grid-column:' + col + ';--srv:' + esc(s.color || PALETTE[0]) + '"' +
            ' title="' + esc(title) + '">';

        var nodes = (s.nodes || []).slice().sort(function (a, b) { return a.node_number - b.node_number; });
        if (!nodes.length) {
            html += '<button type="button" class="rb-addnode" data-action="add-node">+ add node</button>';
        } else {
            var L = nodeLayout(Math.max(s.num_nodes || 1, nodes.length), s.u_height);
            html += '<div class="rb-nodes" style="grid-template-columns:repeat(' + L.cols + ',minmax(0,1fr));grid-template-rows:repeat(' + L.rows + ',minmax(0,1fr))">';
            nodes.forEach(function (n) {
                var p = nodePos(n.node_number, L, view);
                var name = esc(nodeName(n));
                html += '<div class="rb-node" data-action="edit-node" data-node-id="' + n.id + '" style="grid-area:' + p.r + '/' + p.c + '" title="' + esc(nodeTitle(n)) + '">' +
                    led(n.status_light) +
                    '<span class="rb-node-name">' + (n.device
                        ? '<a class="rb-devlink" href="' + DEVICE_URL + '/' + n.device.device_id + '/" target="_blank" rel="noopener">' + name + '</a>'
                        : name) + '</span></div>';
            });
            html += '</div>';
        }
        html += actionsHTML();
        return html + '</div>';
    }

    function actionsHTML() {
        return '<div class="rb-actions">' +
            '<button type="button" data-action="edit-server" title="Edit server"><i class="fa fa-pencil"></i></button>' +
            '<button type="button" class="rb-act-del" data-action="delete-server" title="Remove server"><i class="fa fa-trash"></i></button>' +
            '</div>';
    }

    function sideServerHTML(s, gridArea) {
        var title = s.name + ' · ' + s.u_height + 'U @ U' + s.u_position + (s.description ? '\n' + s.description : '');
        return '<div class="rb-server" draggable="true" data-action="edit-server" data-server-id="' + s.id + '"' +
            ' style="grid-area:' + gridArea + ';--srv:' + esc(s.color || PALETTE[0]) + '" title="' + esc(title) + '">' +
            '<div class="rb-side-label">' + led(worstStatus(s.nodes)) + '<span>' + esc(s.name) + '</span></div>' +
            actionsHTML() + '</div>';
    }

    function renderSide(grid, servers) {
        var occ = {};
        servers.forEach(function (s) {
            for (var u = s.u_position; u < s.u_position + s.u_height; u++) occ[u] = s;
        });
        grid.className = 'rb-grid ' + (state.compact ? 'rb-side-compact' : 'rb-side-full');
        var panel = grid.dataset.panel, html = '';

        if (state.compact) {
            for (var u = SIDE_SIZE; u >= 1; u--) {
                var row = SIDE_SIZE - u + 1, s = occ[u];
                html += '<div class="rb-u rb-u-left" style="grid-area:' + row + '/1">' + u + '</div>';
                if (s) {
                    if (u === s.u_position) html += sideServerHTML(s, topRow(s, SIDE_SIZE) + ' / 2 / span ' + s.u_height + ' / 3');
                } else {
                    html += '<div class="rb-empty" data-action="add" data-panel="' + panel + '" data-u="' + u + '" style="grid-area:' + row + '/2" title="U' + u + '"></div>';
                }
            }
        } else {
            [[5, 6], [3, 4], [1, 2]].forEach(function (pair, gi) {
                var row = gi + 1, a = occ[pair[0]], b = occ[pair[1]];
                if (a && a === b) {
                    html += sideServerHTML(a, row + ' / 1 / ' + row + ' / span 2');
                    return;
                }
                pair.forEach(function (u, ci) {
                    var s = occ[u];
                    if (s) {
                        if (u === s.u_position) html += sideServerHTML(s, row + ' / ' + (ci + 1));
                    } else {
                        html += '<div class="rb-empty" data-action="add" data-panel="' + panel + '" data-u="' + u + '" data-label="U' + u + '" style="grid-area:' + row + '/' + (ci + 1) + '" title="U' + u + '"></div>';
                    }
                });
            });
        }
        grid.innerHTML = html;
    }

    function renderStats() {
        var size = state.rack.size, used = 0;
        var mainSrv = state.servers.filter(function (s) { return panelOf(s) === 'main'; });
        for (var u = 1; u <= size; u++) {
            if (mainSrv.some(function (s) { return u >= s.u_position && u < s.u_position + s.u_height; })) used++;
        }
        var counts = { green: 0, yellow: 0, red: 0, black: 0, grey: 0 };
        state.servers.forEach(function (s) {
            (s.nodes || []).forEach(function (n) { counts[n.status_light || 'grey']++; });
        });
        // Nodes = individual machines (a 2U/4-node chassis counts as 4). Tooltip breaks it down by chassis type.
        var nodeTotal = 0, byType = {};
        state.servers.forEach(function (s) {
            var n = (s.nodes || []).length || s.num_nodes || 1;
            nodeTotal += n;
            byType[n] = (byType[n] || 0) + 1;
        });
        var breakdown = Object.keys(byType).sort().map(function (n) {
            return byType[n] + ' × ' + (n === '1' ? 'standalone' : n + '-node');
        }).join(', ');
        var plural = function (n, word) { return '<b>' + n + '</b> ' + word + (n === 1 ? '' : 's'); };

        var pct = Math.round(used / size * 100);
        var html = '<span class="rb-chip" title="' + used + ' of ' + size + 'U occupied">' +
            '<span class="rb-meter"><i style="width:' + pct + '%"></i></span><b>' + used + '</b>/' + size + 'U</span>' +
            '<span class="rb-chip" title="Physical boxes in the rack' + (breakdown ? ': ' + breakdown : '') + '"><i class="fa fa-server"></i> ' + plural(state.servers.length, 'server') + '</span>' +
            '<span class="rb-chip" title="Individual nodes across all servers"><i class="fa fa-th-large"></i> ' + plural(nodeTotal, 'node') + '</span>';
        ['green', 'yellow', 'red', 'black', 'grey'].forEach(function (k) {
            html += '<span class="rb-chip' + (counts[k] ? '' : ' is-zero') + '" title="' + STATUS[k].label + '">' +
                led(k) + '<b>' + counts[k] + '</b> ' + STATUS[k].label + '</span>';
        });
        $('#rb-stats').innerHTML = html;
    }

    // ------------------------------------------------------------------
    // Status polling
    // ------------------------------------------------------------------
    function startPolling() {
        stopPolling();
        state.pollTimer = setInterval(function () { if (!document.hidden) pollStatus(); }, POLL_MS);
    }

    function stopPolling() {
        if (state.pollTimer) clearInterval(state.pollTimer);
        state.pollTimer = null;
    }

    async function pollStatus() {
        if (!state.rack || state.drag) return;
        var rackId = state.rack.id, data;
        try { data = await api('GET', '/racks/' + rackId + '/status'); } catch (e) { return; }
        if (!state.rack || state.rack.id !== rackId) return;

        var changed = [];
        state.servers.forEach(function (s) {
            (s.nodes || []).forEach(function (n) {
                var st = data[n.id];
                if (!st) return;
                if (n.device) { n.device.status = st.status; n.device.uptime = st.uptime; }
                if ((n.status_light || 'grey') !== st.status_light) {
                    n.status_light = st.status_light;
                    changed.push(n.id);
                }
            });
        });
        if (!changed.length) return;

        renderRack(false);
        changed.forEach(function (id) {
            $$('.rb-node[data-node-id="' + id + '"] .rb-led').forEach(function (el) { el.classList.add('is-changed'); });
        });
    }

    document.addEventListener('visibilitychange', function () {
        if (!document.hidden && state.rack) pollStatus();
    });

    // ------------------------------------------------------------------
    // Server modal
    // ------------------------------------------------------------------
    $('#rb-swatches').innerHTML = PALETTE.map(function (c, i) {
        return '<label class="rb-swatch" title="' + c + '"><input type="radio" name="color" value="' + c + '"' + (i === 0 ? ' checked' : '') + '><span style="background:' + c + '"></span></label>';
    }).join('');

    var sf = $('#rb-server-form');

    function serverPanel() { return state.rack && state.rack.layout === 'telecom' ? sf.elements.panel.value : 'main'; }

    function applyPanelConstraints(height) {
        var side = serverPanel() !== 'main';
        $('#rb-main-only').hidden = side;
        if (side) { sf.elements.slot_position.value = 'full'; sf.elements.side.value = 'both'; }
        var max = side ? 2 : 8, sel = sf.elements.u_height;
        sel.innerHTML = '';
        for (var h = 1; h <= max; h++) sel.add(new Option(h + 'U', h));
        sel.value = Math.min(height || 1, max);
    }

    function refreshPositions(preferred) {
        var panel = serverPanel(), side = panel !== 'main';
        var h = parseInt(sf.elements.u_height.value, 10);
        var slot = side ? 'full' : sf.elements.slot_position.value;
        var face = side ? 'both' : sf.elements.side.value;
        var excl = state.editingServer ? state.editingServer.id : null;
        var max = panelSize(panel);
        var sel = sf.elements.u_position;
        var current = preferred !== undefined ? +preferred : +sel.value;

        var positions = [];
        if (side && h === 2) positions = [1, 3, 5];
        else for (var p = max - h + 1; p >= 1; p--) positions.push(p);
        if (side) positions.sort(function (a, b) { return b - a; });

        sel.innerHTML = '';
        var firstFree = null;
        positions.forEach(function (p) {
            var free = canPlace(excl, panel, p, h, slot, face);
            var label = 'U' + p + (h > 1 ? ' – U' + (p + h - 1) : '');
            if (side) label += ' · group ' + Math.ceil(p / 2);
            var opt = new Option(label + (free ? '' : '  (occupied)'), p);
            opt.disabled = !free;
            sel.add(opt);
            if (free && firstFree === null) firstFree = p;
        });
        var ok = positions.indexOf(current) >= 0 && canPlace(excl, panel, current, h, slot, face);
        sel.value = ok ? current : (firstFree !== null ? firstFree : positions[0]);
    }

    sf.elements.panel.addEventListener('change', function () { applyPanelConstraints(1); refreshPositions(); });
    ['u_height', 'slot_position', 'side'].forEach(function (n) {
        sf.elements[n].addEventListener('change', function () { refreshPositions(); });
    });

    function showServerModal(server, opts) {
        opts = opts || {};
        sf.reset();
        state.editingServer = server || null;
        var telecom = state.rack && state.rack.layout === 'telecom';
        $('#rb-panel-group').hidden = !telecom;
        $('#rb-server-title').textContent = server ? 'Edit server · ' + server.name : 'Add server';
        $('#rb-server-delete').hidden = !server;

        sf.elements.panel.value = server ? panelOf(server) : (opts.panel || 'main');
        applyPanelConstraints(server ? server.u_height : 1);

        if (server) {
            sf.elements.name.value = server.name;
            sf.elements.num_nodes.value = String(server.num_nodes);
            if (sf.elements.num_nodes.value !== String(server.num_nodes)) {
                sf.elements.num_nodes.add(new Option(server.num_nodes + ' nodes', server.num_nodes));
                sf.elements.num_nodes.value = String(server.num_nodes);
            }
            sf.elements.slot_position.value = slotOf(server);
            sf.elements.side.value = sideOf(server);
            sf.elements.description.value = server.description || '';
            var sw = sf.querySelector('input[name="color"][value="' + (server.color || PALETTE[0]) + '"]');
            if (sw) sw.checked = true;
            refreshPositions(server.u_position);
        } else {
            if (opts.u && serverPanel() === 'main') {
                // Clicked an empty half: prefer full width, fall back to that half if the other one is taken.
                if (!canPlace(null, 'main', opts.u, 1, 'full', 'both') && opts.slot) sf.elements.slot_position.value = opts.slot;
            }
            refreshPositions(opts.u);
        }

        renderNodeEditors(server);
        modal('rb-server-modal', 'show');
    }

    function renderNodeEditors(server) {
        var box = $('#rb-node-editors');
        box.innerHTML = '';
        if (!server || !server.nodes || !server.nodes.length) return;

        box.insertAdjacentHTML('beforeend', '<div class="rb-section-title">Nodes</div>');
        server.nodes.slice().sort(function (a, b) { return a.node_number - b.node_number; }).forEach(function (n) {
            var card = document.createElement('div');
            card.className = 'rb-nodecard';
            card.dataset.nodeId = n.id;
            card.dataset.nodeNumber = n.node_number;
            card.innerHTML =
                '<div class="rb-nodecard-title">' + led(n.status_light) + 'Node ' + n.node_number + '</div>' +
                '<div class="row">' +
                '<div class="col-sm-4 form-group"><input type="text" class="form-control input-sm" data-f="label" maxlength="255" placeholder="Label"></div>' +
                '<div class="col-sm-4 form-group"><div class="rb-ds"><input type="text" class="form-control input-sm" data-f="device" placeholder="Link device…" autocomplete="off"></div></div>' +
                '<div class="col-sm-4 form-group"><input type="text" class="form-control input-sm" data-f="description" placeholder="Display name (optional)"></div>' +
                '</div>';
            var label = card.querySelector('[data-f=label]');
            var dev = card.querySelector('[data-f=device]');
            var desc = card.querySelector('[data-f=description]');
            label.value = n.label || '';
            desc.value = n.description || '';
            dev.value = n.device ? (n.device.display || n.device.hostname) : '';
            card.dataset.deviceId = n.device_id || '';
            card.dataset.orig = JSON.stringify([label.value, card.dataset.deviceId, desc.value]);
            attachDeviceSearch(dev, function (d) { card.dataset.deviceId = d ? d.id : ''; });
            box.appendChild(card);
        });
    }

    async function saveNodeEditors(maxNodes) {
        var cards = $$('#rb-node-editors .rb-nodecard');
        for (var i = 0; i < cards.length; i++) {
            var c = cards[i];
            if (+c.dataset.nodeNumber > maxNodes) continue; // will be removed by the server update
            var label = c.querySelector('[data-f=label]').value.trim() || ('Node ' + c.dataset.nodeNumber);
            var desc = c.querySelector('[data-f=description]').value;
            if (JSON.stringify([label, c.dataset.deviceId, desc]) === c.dataset.orig) continue;
            await api('PUT', '/nodes/' + c.dataset.nodeId, {
                label: label,
                device_id: c.dataset.deviceId ? +c.dataset.deviceId : null,
                description: desc || null
            });
        }
    }

    async function saveServer(e) {
        e.preventDefault();
        if (!state.rack) return;
        if (!sf.elements.name.value.trim()) { sf.elements.name.focus(); return; }
        var panel = serverPanel(), side = panel !== 'main';
        var data = {
            panel: panel,
            name: sf.elements.name.value.trim(),
            u_height: parseInt(sf.elements.u_height.value, 10),
            u_position: parseInt(sf.elements.u_position.value, 10),
            num_nodes: parseInt(sf.elements.num_nodes.value, 10),
            slot_position: side ? 'full' : sf.elements.slot_position.value,
            side: side ? 'both' : sf.elements.side.value,
            description: sf.elements.description.value || null,
            color: (sf.querySelector('input[name="color"]:checked') || {}).value || null
        };
        var btn = sf.querySelector('[type=submit]');
        setBusy(btn, true);
        try {
            if (state.editingServer) {
                await saveNodeEditors(data.num_nodes);
                await api('PUT', '/servers/' + state.editingServer.id, data);
            } else {
                data.rack_id = state.rack.id;
                await api('POST', '/servers', data);
            }
            modal('rb-server-modal', 'hide');
            notify('success', state.editingServer ? 'Server updated' : 'Server added');
            await loadRackData(false);
        } catch (err) {
            notify('error', err.message);
        } finally {
            setBusy(btn, false);
        }
    }

    async function deleteServer(id) {
        var s = findServer(id);
        if (!s || !window.confirm('Remove "' + s.name + '" from the rack?')) return false;
        try {
            await api('DELETE', '/servers/' + id);
            notify('success', 'Server removed');
            await loadRackData(false);
            return true;
        } catch (e) {
            notify('error', e.message);
            return false;
        }
    }

    // ------------------------------------------------------------------
    // Node modal
    // ------------------------------------------------------------------
    var nf = $('#rb-node-form');
    var nodeDeviceInput = $('#rb-node-device');

    function setNodeLinked(dev) {
        state.nodeDeviceId = dev ? dev.id : null;
        $('#rb-node-linked').innerHTML = dev
            ? led(dev.status_light) + '<a href="' + DEVICE_URL + '/' + dev.id + '/" target="_blank" rel="noopener">' + esc(dev.text) + '</a>' +
              '<button type="button" class="btn btn-link" data-action="unlink-device" title="Unlink device"><i class="fa fa-times"></i> unlink</button>'
            : '<span class="rb-hint" style="margin:0">No device linked</span>';
    }

    attachDeviceSearch(nodeDeviceInput, setNodeLinked);

    function showNodeModal(node, server) {
        nf.reset();
        state.editingNode = node || null;
        state.editingNodeServer = server;
        $('#rb-node-title').textContent = (node ? 'Edit node ' + node.node_number : 'Add node') + ' · ' + server.name;
        if (node) {
            nf.elements.label.value = node.label || '';
            nf.elements.description.value = node.description || '';
            if (node.device) {
                nodeDeviceInput.value = node.device.display || node.device.hostname;
                setNodeLinked({ id: node.device.device_id, text: node.device.display || node.device.hostname, status_light: node.status_light });
            } else {
                setNodeLinked(null);
            }
        } else {
            var used = (server.nodes || []).map(function (n) { return n.node_number; });
            var next = 1;
            while (used.indexOf(next) >= 0) next++;
            nf.dataset.nodeNumber = next;
            nf.elements.label.value = server.nodes && server.nodes.length ? 'Node ' + next : server.name;
            setNodeLinked(null);
        }
        modal('rb-node-modal', 'show');
    }

    async function saveNode(e) {
        e.preventDefault();
        if (!nf.elements.label.value.trim()) { nf.elements.label.focus(); return; }
        var data = {
            label: nf.elements.label.value.trim(),
            device_id: state.nodeDeviceId ? +state.nodeDeviceId : null,
            description: nf.elements.description.value || null
        };
        var btn = nf.querySelector('[type=submit]');
        setBusy(btn, true);
        try {
            if (state.editingNode) {
                await api('PUT', '/nodes/' + state.editingNode.id, data);
            } else {
                data.server_id = state.editingNodeServer.id;
                data.node_number = +nf.dataset.nodeNumber;
                await api('POST', '/nodes', data);
            }
            modal('rb-node-modal', 'hide');
            notify('success', 'Node saved');
            await loadRackData(false);
        } catch (err) {
            notify('error', err.message);
        } finally {
            setBusy(btn, false);
        }
    }

    // ------------------------------------------------------------------
    // Device search (autocomplete with keyboard support)
    // ------------------------------------------------------------------
    function attachDeviceSearch(input, onChange) {
        var list = document.createElement('div');
        list.className = 'rb-ds-list';
        input.parentNode.appendChild(list);
        var timer = null, seq = 0, items = [], active = -1;

        function close() { list.classList.remove('is-open'); active = -1; }
        function highlight(i) {
            active = i;
            $$('.rb-ds-item', list).forEach(function (el, j) { el.classList.toggle('is-active', j === i); });
            var el = list.children[i];
            if (el && el.scrollIntoView) el.scrollIntoView({ block: 'nearest' });
        }
        function pick(d) {
            input.value = d.text;
            close();
            onChange(d);
        }

        input.addEventListener('input', function () {
            onChange(null);
            clearTimeout(timer);
            var term = input.value.trim();
            if (term.length < 2) { close(); return; }
            timer = setTimeout(async function () {
                var my = ++seq;
                list.innerHTML = '<div class="rb-ds-empty"><i class="fa fa-spinner fa-spin"></i> Searching…</div>';
                list.classList.add('is-open');
                try {
                    var res = await api('GET', '/devices/search?q=' + encodeURIComponent(term));
                    if (my !== seq) return;
                    items = res;
                    list.innerHTML = items.length
                        ? items.map(function (d) {
                            return '<div class="rb-ds-item">' + led(d.status_light) + '<span>' + esc(d.text) + '</span>' +
                                (d.hostname && d.hostname !== d.text ? '<small>' + esc(d.hostname) + '</small>' : '') + '</div>';
                        }).join('')
                        : '<div class="rb-ds-empty">No matching devices</div>';
                    $$('.rb-ds-item', list).forEach(function (el, i) {
                        el.addEventListener('mousedown', function (ev) { ev.preventDefault(); pick(items[i]); });
                    });
                    active = -1;
                } catch (e) {
                    if (my === seq) list.innerHTML = '<div class="rb-ds-empty">Search failed</div>';
                }
            }, 250);
        });

        input.addEventListener('keydown', function (e) {
            if (!list.classList.contains('is-open') || !items.length) return;
            if (e.key === 'ArrowDown') { e.preventDefault(); highlight(Math.min(items.length - 1, active + 1)); }
            else if (e.key === 'ArrowUp') { e.preventDefault(); highlight(Math.max(0, active - 1)); }
            else if (e.key === 'Enter' && active >= 0) { e.preventDefault(); pick(items[active]); }
            else if (e.key === 'Escape') { e.stopPropagation(); close(); }
        });

        input.addEventListener('blur', function () { setTimeout(close, 120); });
    }

    // ------------------------------------------------------------------
    // Drag and drop
    // ------------------------------------------------------------------
    function gridBounds(grid) {
        var labels = grid.querySelectorAll('.rb-u');
        var r = grid.getBoundingClientRect();
        if (!labels.length) return { top: r.top, bottom: r.bottom, left: r.left, right: r.right };
        return {
            top: labels[0].getBoundingClientRect().top,
            bottom: labels[labels.length - 1].getBoundingClientRect().bottom,
            left: r.left, right: r.right
        };
    }

    // U under the pointer (the full-mode side panel resolves to a single U per cell)
    function uAt(grid, x, y) {
        var panel = grid.dataset.panel;
        var b = gridBounds(grid);
        var fy = Math.max(0, Math.min(0.9999, (y - b.top) / Math.max(1, b.bottom - b.top)));
        if (panel === 'main') {
            var size = panelSize('main');
            return size - Math.floor(fy * size);
        }
        if (state.compact) return SIDE_SIZE - Math.floor(fy * SIDE_SIZE);
        var grp = Math.floor(fy * 3);
        var col = x > (b.left + b.right) / 2 ? 1 : 0;
        return (2 - grp) * 2 + col + 1;
    }

    function dropTarget(grid, e) {
        var d = state.drag, s = d.server;
        var panel = grid.dataset.panel, view = grid.dataset.view;
        var h = s.u_height, max = panelSize(panel);
        var isSide = panel !== 'main';
        var u = uAt(grid, e.clientX, e.clientY) - (isSide ? 0 : d.grabOffset);
        if (isSide && h === 2) u = u - ((u - 1) % 2);
        u = Math.max(1, Math.min(max - h + 1, u));

        var slot = 'full', side = 'both';
        if (!isSide) {
            side = sideOf(s);
            slot = slotOf(s);
            if (slot !== 'full') {
                var b = gridBounds(grid);
                var leftHalf = e.clientX < (b.left + b.right) / 2;
                slot = (leftHalf !== (view === 'back')) ? 'left' : 'right';
            }
        }

        var t = { grid: grid, panel: panel, view: view, u: u, slot: slot, side: side, h: h, valid: true, reason: '' };
        if (panel !== panelOf(s)) { t.valid = false; t.reason = 'Servers can\'t be moved between panels'; }
        else if (isSide && h > 2) { t.valid = false; t.reason = 'Side panels only take 1U/2U servers'; }
        else if (!canPlace(s.id, panel, u, h, slot, side)) { t.valid = false; t.reason = 'That position is occupied'; }
        return t;
    }

    function previewArea(t) {
        if (t.panel === 'main') {
            var row = panelSize('main') - (t.u + t.h - 1) + 1;
            return row + ' / ' + (t.slot === 'full' ? '2' : halfColumn(t.slot, t.view)) + ' / span ' + t.h + ' / ' + (t.slot === 'full' ? 'span 2' : 'span 1');
        }
        if (state.compact) return (SIDE_SIZE - (t.u + t.h - 1) + 1) + ' / 2 / span ' + t.h + ' / 3';
        var gRow = 4 - Math.ceil(t.u / 2);
        return t.h === 2 ? gRow + ' / 1 / ' + gRow + ' / span 2' : gRow + ' / ' + (((t.u - 1) % 2) + 1);
    }

    function clearPreview() { $$('.rb-drop').forEach(function (p) { p.remove(); }); }

    function showPreview(t) {
        clearPreview();
        var p = document.createElement('div');
        p.className = 'rb-drop' + (t.valid ? '' : ' is-invalid');
        p.style.gridArea = previewArea(t);
        t.grid.appendChild(p);
    }

    function endDrag() {
        clearPreview();
        $$('.rb-server.is-dragging').forEach(function (b) { b.classList.remove('is-dragging'); });
        root.classList.remove('is-dragging');
        state.drag = null;
    }

    root.addEventListener('dragstart', function (e) {
        var blk = e.target.closest && e.target.closest('.rb-server');
        if (!blk) return;
        if (!CAN_EDIT) { e.preventDefault(); return; }
        var s = findServer(blk.dataset.serverId);
        if (!s) return;
        var grid = blk.closest('.rb-grid');
        var grabOffset = 0;
        if (grid.dataset.panel === 'main') {
            grabOffset = Math.max(0, Math.min(s.u_height - 1, uAt(grid, e.clientX, e.clientY) - s.u_position));
        }
        state.drag = { server: s, grabOffset: grabOffset, key: null };

        var ghost = document.createElement('div');
        ghost.className = 'rb-ghost';
        ghost.textContent = s.name + ' · ' + s.u_height + 'U';
        ghost.style.background = s.color || PALETTE[0];
        document.body.appendChild(ghost);
        e.dataTransfer.setDragImage(ghost, 10, 10);
        setTimeout(function () { ghost.remove(); }, 0);
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/plain', String(s.id));

        requestAnimationFrame(function () {
            $$('.rb-server[data-server-id="' + s.id + '"]').forEach(function (b) { b.classList.add('is-dragging'); });
            root.classList.add('is-dragging');
        });
    });

    root.addEventListener('dragover', function (e) {
        if (!state.drag) return;
        var grid = e.target.closest && e.target.closest('.rb-grid');
        if (!grid) return;
        e.preventDefault();
        var t = dropTarget(grid, e);
        e.dataTransfer.dropEffect = t.valid ? 'move' : 'none';
        var key = grid.id + ':' + t.u + ':' + t.slot + ':' + t.valid;
        if (key !== state.drag.key) { state.drag.key = key; showPreview(t); }
    });

    root.addEventListener('dragleave', function (e) {
        if (!state.drag) return;
        var to = e.relatedTarget;
        if (!to || !to.closest || !to.closest('.rb-grid')) { clearPreview(); state.drag.key = null; }
    });

    root.addEventListener('drop', function (e) {
        if (!state.drag) return;
        var grid = e.target.closest && e.target.closest('.rb-grid');
        if (!grid) return;
        e.preventDefault();
        var t = dropTarget(grid, e);
        var s = state.drag.server;
        endDrag();
        if (!t.valid) { notify('warning', t.reason); return; }
        if (t.u === s.u_position && t.slot === slotOf(s)) return;
        moveServer(s, t.u, t.slot);
    });

    root.addEventListener('dragend', endDrag);

    async function moveServer(s, u, slot) {
        var prev = { u: s.u_position, slot: s.slot_position };
        s.u_position = u;           // optimistic update
        s.slot_position = slot;
        renderRack(false);
        try {
            await api('PUT', '/servers/' + s.id, {
                panel: panelOf(s), name: s.name, u_height: s.u_height, u_position: u,
                num_nodes: s.num_nodes, slot_position: slot, side: sideOf(s),
                description: s.description || null, color: s.color || null
            });
        } catch (err) {
            s.u_position = prev.u;
            s.slot_position = prev.slot;
            renderRack(false);
            notify('error', err.message);
        }
    }

    // ------------------------------------------------------------------
    // Zoom / view / theme / print
    // ------------------------------------------------------------------
    function applyZoom() {
        state.zoom = Math.round(Math.max(0.4, Math.min(2, state.zoom)) * 100) / 100;
        $('#rb-wrapper').style.zoom = state.zoom;
        $('#rb-zoom-label').textContent = Math.round(state.zoom * 100) + '%';
        store.set('rackbuilder_zoom', state.zoom);
    }

    function zoomFit() {
        var w = $('#rb-wrapper');
        w.style.zoom = 1;
        var top = Math.max(60, w.getBoundingClientRect().top);
        var avail = window.innerHeight - top - 24;
        state.zoom = Math.floor(Math.min(1.5, avail / w.scrollHeight) * 20) / 20;
        applyZoom();
    }

    function applyCompact() {
        root.classList.toggle('is-compact', state.compact);
        var btn = $('#rb-compact-btn');
        btn.classList.toggle('active', state.compact);
        btn.title = state.compact ? 'Switch to normal view' : 'Switch to compact view';
        btn.innerHTML = '<i class="fa fa-' + (state.compact ? 'expand' : 'compress') + '"></i>';
    }

    function detectTheme() {
        var html = document.documentElement;
        return html.classList.contains('dark') || html.dataset.theme === 'dark' ? 'dark' : 'light';
    }

    function applyTheme() { root.setAttribute('data-rack-theme', detectTheme()); }

    function printRack() {
        if (!state.rack) return;
        var w = window.open('', '_blank', 'width=1100,height=900');
        if (!w) { notify('error', 'Pop-up blocked — allow pop-ups to print'); return; }

        var wrapper = $('#rb-wrapper').cloneNode(true);
        wrapper.style.zoom = '';
        wrapper.classList.remove('is-loading');
        $$('.rb-actions, .rb-drop, .rb-addnode', wrapper).forEach(function (el) { el.remove(); });

        var r = state.rack;
        var css = document.getElementById('rb-styles').textContent +
            '@page{size:portrait;margin:8mm}' +
            'body{margin:0;background:#fff;font-family:-apple-system,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;}' +
            '*{-webkit-print-color-adjust:exact!important;print-color-adjust:exact!important}' +
            '#rack-builder{--u-h:15px;--side-h:52px;--node-font:7.5px;--rail:18px}' +
            '#rack-builder .rb-face{min-width:0;max-width:none}' +
            '#rack-builder .rb-face-side{flex-basis:70px}' +
            '#rack-builder .rb-wrapper{gap:10px}' +
            '#rack-builder .rb-cabinet{box-shadow:none;padding:6px 4px}' +
            '#rack-builder .rb-server{animation:none}' +
            '#rack-builder .rb-led{animation:none!important}' +
            '#rack-builder .rb-empty::after,#rack-builder .rb-empty::before{display:none}' +
            '.rb-print-head{display:flex;justify-content:space-between;align-items:flex-end;border-bottom:2px solid #222;padding-bottom:6px;margin-bottom:10px}' +
            '.rb-print-head h1{font-size:18px;margin:0}.rb-print-head div{font-size:11px;color:#555;text-align:right}' +
            '.rb-print-legend{display:flex;flex-wrap:wrap;gap:6px;justify-content:center;margin-top:8px}';

        w.document.open();
        w.document.write('<!DOCTYPE html><html><head><meta charset="utf-8"><title>' + esc(r.name) + ' — RackBuilder</title><style>' + css + '</style></head><body>' +
            '<div id="rack-builder" data-rack-theme="light" class="' + (state.compact ? 'is-compact' : '') + '">' +
            '<div class="rb-print-head"><div style="text-align:left"><h1>' + esc(r.name) + '</h1>' + (r.description ? esc(r.description) : '') + '</div>' +
            '<div>' + r.size + 'U · ' + (r.layout === 'telecom' ? 'Telecom' : 'Standard') + '<br>Printed ' + esc(new Date().toLocaleString()) + '</div></div>' +
            wrapper.outerHTML +
            '<div class="rb-print-legend">' + $('#rb-stats').innerHTML + '</div>' +
            '</div></body></html>');
        w.document.close();
        w.focus();
        setTimeout(function () { w.print(); }, 400);
    }

    // ------------------------------------------------------------------
    // Event wiring
    // ------------------------------------------------------------------
    root.addEventListener('click', function (e) {
        if (e.target.closest('a[href]')) return; // device links open normally
        var el = e.target.closest('[data-action]');
        if (!el || !root.contains(el)) return;
        if (!CAN_EDIT && WRITE_ACTIONS.indexOf(el.dataset.action) >= 0) return;
        var holder = el.closest('[data-server-id]');
        var server = holder ? findServer(holder.dataset.serverId) : null;

        switch (el.dataset.action) {
            case 'new-rack':      showRackModal(null); break;
            case 'edit-rack':     showRackModal(state.rack); break;
            case 'delete-rack':   deleteRack(); break;
            case 'add-server':    showServerModal(null); break;
            case 'add':           showServerModal(null, { u: +el.dataset.u, slot: el.dataset.slot, panel: el.dataset.panel }); break;
            case 'edit-server':   if (server) showServerModal(server); break;
            case 'delete-server': if (server) deleteServer(server.id); break;
            case 'add-node':      if (server) showNodeModal(null, server); break;
            case 'edit-node':
                if (server) {
                    var node = (server.nodes || []).find(function (n) { return n.id === +el.dataset.nodeId; });
                    if (node) showNodeModal(node, server);
                }
                break;
            case 'delete-server-modal':
                if (state.editingServer) {
                    deleteServer(state.editingServer.id).then(function (ok) { if (ok) modal('rb-server-modal', 'hide'); });
                }
                break;
            case 'unlink-device': nodeDeviceInput.value = ''; setNodeLinked(null); break;
            case 'zoom-in':       state.zoom += 0.1; applyZoom(); break;
            case 'zoom-out':      state.zoom -= 0.1; applyZoom(); break;
            case 'zoom-reset':    state.zoom = 1; applyZoom(); break;
            case 'zoom-fit':      zoomFit(); break;
            case 'compact':
                state.compact = !state.compact;
                store.set('rackbuilder_compact', state.compact);
                applyCompact();
                renderRack(false);
                break;
            case 'print':         printRack(); break;
        }
    });

    $('#rb-rack-select').addEventListener('change', function () { selectRack(this.value); });
    $('#rb-rack-form').addEventListener('submit', saveRack);
    sf.addEventListener('submit', saveServer);
    nf.addEventListener('submit', saveNode);

    // Autofocus the first field when a modal opens
    window.jQuery(root).on('shown.bs.modal', '.rb-modal', function () {
        var first = this.querySelector('input[type=text]');
        if (first) first.focus();
    });

    new MutationObserver(applyTheme).observe(document.documentElement, { attributes: true, attributeFilter: ['class', 'data-theme'] });

    // ------------------------------------------------------------------
    // Init
    // ------------------------------------------------------------------
    root.classList.toggle('is-readonly', !CAN_EDIT);
    applyTheme();
    applyCompact();
    applyZoom();
    loadRacks();
})();
</script>
