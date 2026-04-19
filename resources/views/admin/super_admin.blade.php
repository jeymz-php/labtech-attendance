<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - UCC LabTech</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green-dark:  #1a4d2e;
            --green-mid:   #2d6a4f;
            --green-main:  #2e7d32;
            --green-pale:  #e8f5e9;
            --green-border:#c8e6c9;
            --red:         #e53935;
            --red-pale:    #fff5f5;
            --orange:      #fb8c00;
            --orange-pale: #fff8e1;
            --blue:        #1565c0;
            --blue-pale:   #e3f2fd;
            --text-dark:   #1b1b1b;
            --text-mid:    #4a4a4a;
            --text-muted:  #888;
            --white:       #ffffff;
            --bg:          #f4f6f4;
            --sidebar-w:   240px;
        }
        body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text-dark); display: flex; min-height: 100vh; }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-w); background: var(--green-dark); color: var(--white);
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; bottom: 0; z-index: 100;
        }
        .sidebar-logo {
            padding: 22px 20px; display: flex; align-items: center; gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }
        .logo-box { width: 36px; height: 36px; background: var(--white); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 11px; color: var(--green-main); flex-shrink: 0; }
        .sidebar-logo .brand { font-weight: 700; font-size: 14px; }
        .sidebar-logo small { font-size: 10px; opacity: .55; display: block; }

        .sidebar-user {
            padding: 14px 20px; border-bottom: 1px solid rgba(255,255,255,.08);
            display: flex; align-items: center; gap: 10px;
        }
        .user-avatar { width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,.15); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; flex-shrink: 0; }
        .user-name { font-size: 13px; font-weight: 600; }
        .user-role { font-size: 10px; opacity: .55; }

        .sidebar-nav { padding: 12px 0; flex: 1; overflow-y: auto; }
        .nav-section { padding: 0 12px; }
        .nav-section-title { font-size: 10px; font-weight: 700; letter-spacing: 1px; opacity: .35; text-transform: uppercase; margin: 14px 0 5px 4px; }
        .nav-link {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: 8px;
            font-size: 13px; font-weight: 500; color: rgba(255,255,255,.7);
            text-decoration: none; cursor: pointer; transition: all .2s; margin-bottom: 2px;
            background: none; border: none; width: 100%; text-align: left;
        }
        .nav-link:hover  { background: rgba(255,255,255,.08); color: var(--white); }
        .nav-link.active { background: rgba(255,255,255,.15); color: var(--white); }
        .nav-link svg { width: 16px; height: 16px; flex-shrink: 0; }
        .nav-badge { margin-left: auto; background: var(--red); color: var(--white); font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 10px; min-width: 18px; text-align: center; }

        .sidebar-footer { padding: 14px 20px; border-top: 1px solid rgba(255,255,255,.08); font-size: 11px; opacity: .4; }

        /* MAIN */
        .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; }
        .topbar {
            background: var(--white); border-bottom: 1px solid #e8e8e8;
            padding: 14px 28px; display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar h1 { font-size: 18px; font-weight: 700; }
        .topbar .sub { font-size: 12px; color: var(--text-muted); margin-top: 1px; }
        .admin-pill { display: flex; align-items: center; gap: 6px; background: var(--green-pale); border: 1px solid var(--green-border); border-radius: 20px; padding: 6px 14px; font-size: 12px; font-weight: 600; color: var(--green-main); }
        .admin-pill svg { width: 13px; height: 13px; }

        .content { padding: 24px 28px; }

        /* VIEWS */
        .view { display: none; }
        .view.active { display: block; }

        /* STAT GRID */
        .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
        .stat-card { background: var(--white); border-radius: 12px; padding: 18px 20px; box-shadow: 0 2px 8px rgba(0,0,0,.06); }
        .stat-label { font-size: 12px; color: var(--text-muted); font-weight: 500; margin-bottom: 6px; }
        .stat-value { font-size: 28px; font-weight: 700; line-height: 1; }
        .stat-value.green  { color: var(--green-main); }
        .stat-value.orange { color: var(--orange); }
        .stat-value.red    { color: var(--red); }
        .stat-value.blue   { color: var(--blue); }
        .stat-sub { font-size: 11px; color: var(--text-muted); margin-top: 4px; }

        /* FILTER BAR */
        .filter-bar { background: var(--white); border-radius: 12px; padding: 14px 20px; margin-bottom: 16px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap; box-shadow: 0 2px 8px rgba(0,0,0,.06); }
        .filter-input { flex: 1; min-width: 180px; border: 1.5px solid #e0e0e0; border-radius: 8px; padding: 8px 12px; font-family: inherit; font-size: 13px; outline: none; }
        .filter-input:focus { border-color: var(--green-main); }
        .filter-select { border: 1.5px solid #e0e0e0; border-radius: 8px; padding: 8px 12px; font-family: inherit; font-size: 13px; outline: none; background: var(--white); cursor: pointer; }
        .filter-select:focus { border-color: var(--green-main); }

        /* TABLE CARD */
        .table-card { background: var(--white); border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.06); overflow: hidden; }
        .table-head { padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f0f0f0; }
        .table-head h2 { font-size: 14px; font-weight: 700; }
        .refresh-btn { border: 1.5px solid var(--green-border); background: var(--green-pale); color: var(--green-main); border-radius: 8px; padding: 6px 14px; font-family: inherit; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; }
        .refresh-btn:hover { background: var(--green-border); }
        .refresh-btn svg { width: 13px; height: 13px; }

        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; font-size: 11px; font-weight: 700; letter-spacing: .5px; text-transform: uppercase; color: var(--text-muted); padding: 10px 20px; border-bottom: 1px solid #f0f0f0; background: #fafafa; }
        td { padding: 12px 20px; font-size: 13px; border-bottom: 1px solid #f7f7f7; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fafff9; }

        .person-cell { display: flex; align-items: center; gap: 10px; }
        .avatar { width: 34px; height: 34px; border-radius: 50%; background: var(--green-pale); color: var(--green-main); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 12px; flex-shrink: 0; }

        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge.student     { background: var(--blue-pale); color: var(--blue); }
        .badge.staff       { background: #f3e5f5; color: #6a1b9a; }
        .badge.practicumer { background: #fff3e0; color: #e65100; }
        .badge.team-leader { background: #fce4ec; color: #880e4f; }
        .badge.super_admin { background: #e8eaf6; color: #283593; }
        .badge.pending     { background: var(--orange-pale); color: var(--orange); }
        .badge.approved    { background: var(--green-pale); color: var(--green-main); }
        .badge.rejected    { background: var(--red-pale); color: var(--red); }

        .action-btns { display: flex; gap: 6px; }
        .btn-approve { background: var(--green-main); color: var(--white); border: none; border-radius: 6px; padding: 5px 10px; font-family: inherit; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 4px; }
        .btn-approve:hover { background: var(--green-mid); }
        .btn-reject  { background: var(--white); color: var(--red); border: 1.5px solid #ffcdd2; border-radius: 6px; padding: 5px 10px; font-family: inherit; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 4px; }
        .btn-reject:hover  { background: var(--red-pale); }
        .btn-view    { background: var(--white); color: var(--text-mid); border: 1.5px solid #e0e0e0; border-radius: 6px; padding: 5px 10px; font-family: inherit; font-size: 12px; cursor: pointer; }
        .btn-view:hover    { border-color: var(--green-border); color: var(--green-main); }
        .btn-approve svg, .btn-reject svg { width: 11px; height: 11px; }

        .time-chip { font-family: 'DM Mono', monospace; font-size: 12px; background: var(--green-pale); color: var(--green-main); padding: 3px 8px; border-radius: 6px; }

        .empty-state { text-align: center; padding: 48px; color: var(--text-muted); font-size: 13px; }
        .empty-state svg { width: 36px; height: 36px; margin: 0 auto 8px; display: block; opacity: .3; }

        .loading-state { text-align: center; padding: 40px; color: var(--text-muted); font-size: 13px; }
        .spinner { display: inline-block; width: 18px; height: 18px; border: 2px solid var(--green-border); border-top-color: var(--green-main); border-radius: 50%; animation: spin .8s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* MODAL */
        .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.4); display: none; align-items: center; justify-content: center; z-index: 200; }
        .modal-overlay.open { display: flex; }
        .modal { background: var(--white); border-radius: 16px; padding: 28px; width: 100%; max-width: 440px; box-shadow: 0 8px 32px rgba(0,0,0,.15); }
        .modal h3 { font-size: 16px; font-weight: 700; margin-bottom: 16px; }
        .modal-row { display: flex; margin-bottom: 10px; gap: 8px; font-size: 13px; }
        .modal-row .lbl { font-weight: 600; width: 120px; flex-shrink: 0; color: var(--text-muted); }
        .modal-btns { display: flex; gap: 8px; margin-top: 20px; flex-wrap: wrap; }

        /* TOAST */
        .toast { position: fixed; bottom: 24px; right: 24px; background: var(--green-dark); color: var(--white); padding: 12px 20px; border-radius: 10px; font-size: 13px; font-weight: 500; box-shadow: 0 4px 16px rgba(0,0,0,.2); transform: translateY(80px); opacity: 0; transition: all .3s; z-index: 999; }
        .toast.show { transform: translateY(0); opacity: 1; }
        .toast.error { background: var(--red); }

        @media (max-width: 960px) {
            .stat-grid { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-box">UCC</div>
        <div>
            <div class="brand">UCC LabTech</div>
            <small>Super Admin Panel</small>
        </div>
    </div>

    <div class="sidebar-user">
        <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
        <div>
            <div class="user-name">{{ Str::limit(auth()->user()->name, 16) }}</div>
            <div class="user-role">Super Admin</div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">
            <div class="nav-section-title">Overview</div>
            <button class="nav-link active" onclick="setView('overview', this)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Overview
            </button>

            <div class="nav-section-title">Registrations</div>
            <button class="nav-link" onclick="setView('pending', this)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Pending Approvals
                <span class="nav-badge" id="pendingBadge">0</span>
            </button>
            <button class="nav-link" onclick="setView('all', this)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                All Registrations
            </button>
            <button class="nav-link" onclick="setView('approved', this)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                Approved
            </button>
            <button class="nav-link" onclick="setView('rejected', this)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                Rejected
            </button>

            <div class="nav-section-title">Monitoring</div>
            <button class="nav-link" onclick="setView('attendance', this)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="23 11 17 11"/></svg>
                Daily Attendance
            </button>

            <div class="nav-section-title">System</div>
            <a class="nav-link" href="{{ route('home') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                Attendance Page
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="sidebar-footer">© {{ date('Y') }} UCC LabTech</div>
</aside>

<!-- MAIN -->
<div class="main">
    <div class="topbar">
        <div>
            <h1 id="pageTitle">Overview</h1>
            <div class="sub">{{ now()->format('l, F d, Y') }}</div>
        </div>
        <div class="admin-pill">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Super Admin
        </div>
    </div>

    <div class="content">

        <!-- ══ OVERVIEW ══ -->
        <div class="view active" id="view-overview">
            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-label">Today's Attendance</div>
                    <div class="stat-value blue" id="ov-today">—</div>
                    <div class="stat-sub">Students logged in</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Pending Approvals</div>
                    <div class="stat-value orange" id="ov-pending">—</div>
                    <div class="stat-sub">Awaiting review</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Approved Accounts</div>
                    <div class="stat-value green" id="ov-approved">—</div>
                    <div class="stat-sub">Active members</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Total Registrations</div>
                    <div class="stat-value" id="ov-total">—</div>
                    <div class="stat-sub">All time</div>
                </div>
            </div>

            <!-- Today's attendance preview -->
            <div class="table-card">
                <div class="table-head">
                    <h2>Today's Attendance</h2>
                    <button class="refresh-btn" onclick="loadOverview()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.95"/></svg>
                        Refresh
                    </button>
                </div>
                <div id="todayAttendanceBody">
                    <div class="loading-state"><span class="spinner"></span></div>
                </div>
            </div>
        </div>

        <!-- ══ REGISTRATIONS VIEW ══ -->
        <div class="view" id="view-registrations">
            <div class="stat-grid" style="grid-template-columns:repeat(3,1fr);">
                <div class="stat-card"><div class="stat-label">Pending</div><div class="stat-value orange" id="reg-pending">—</div></div>
                <div class="stat-card"><div class="stat-label">Approved</div><div class="stat-value green" id="reg-approved">—</div></div>
                <div class="stat-card"><div class="stat-label">Total</div><div class="stat-value" id="reg-total">—</div></div>
            </div>

            <div class="filter-bar">
                <input class="filter-input" id="regSearch" type="text" placeholder="🔍  Search by name, email or student number..." oninput="renderRegistrations()">
                <select class="filter-select" id="roleFilter" onchange="renderRegistrations()">
                    <option value="">All Roles</option>
                    <option value="student">Student</option>
                    <option value="staff">Staff</option>
                    <option value="practicumer">Practicumer</option>
                    <option value="team-leader">Team Leader</option>
                </select>
                <select class="filter-select" id="campusFilter" onchange="renderRegistrations()">
                    <option value="">All Campuses</option>
                    <option>South Campus</option>
                    <option>Congressional</option>
                    <option>Camarin</option>
                    <option>Bagong Silang</option>
                </select>
            </div>

            <div class="table-card">
                <div class="table-head">
                    <h2 id="regTableTitle">Registrations</h2>
                    <button class="refresh-btn" onclick="loadRegistrations()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.95"/></svg>
                        Refresh
                    </button>
                </div>
                <div id="regTableBody"><div class="loading-state"><span class="spinner"></span></div></div>
            </div>
        </div>

        <!-- ══ DAILY ATTENDANCE VIEW ══ -->
        <div class="view" id="view-attendance">
            <div class="filter-bar">
                <input class="filter-input" id="attSearch" type="text" placeholder="🔍  Search name or student number..." oninput="loadAttendance()">
                <input class="filter-select" id="attDate" type="date" value="{{ date('Y-m-d') }}" onchange="loadAttendance()">
                <button class="refresh-btn" onclick="loadAttendance()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.95"/></svg>
                    Refresh
                </button>
            </div>

            <div class="table-card">
                <div class="table-head">
                    <h2>Daily Attendance Log</h2>
                    <span id="attCount" style="font-size:12px;color:var(--text-muted);"></span>
                </div>
                <div id="attTableBody"><div class="loading-state"><span class="spinner"></span></div></div>
            </div>
        </div>

    </div><!-- end content -->
</div>

<!-- MODAL -->
<div class="modal-overlay" id="viewModal">
    <div class="modal">
        <h3>Registration Details</h3>
        <div id="modalBody"></div>
        <div class="modal-btns">
            <button class="btn-approve" id="modalApprove" onclick="approveFromModal()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Approve
            </button>
            <button class="btn-reject" id="modalReject" onclick="rejectFromModal()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Reject
            </button>
            <button class="btn-view" onclick="closeModal()" style="margin-left:auto">Close</button>
        </div>
    </div>
</div>

<div class="toast" id="toast"></div>

<script>
let allRegistrations = [];
let currentView      = 'overview';
let currentRegFilter = 'all';
let modalRecord      = null;

// ── VIEW SWITCHING ──────────────────────────────────────────
const viewTitles = {
    overview:'Overview', pending:'Pending Approvals',
    all:'All Registrations', approved:'Approved',
    rejected:'Rejected', attendance:'Daily Attendance'
};

function setView(view, btn) {
    currentView = view;
    document.querySelectorAll('.view').forEach(v => v.classList.remove('active'));
    document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('pageTitle').textContent = viewTitles[view] ?? view;

    if (['pending','all','approved','rejected'].includes(view)) {
        document.getElementById('view-registrations').classList.add('active');
        currentRegFilter = view;
        if (!allRegistrations.length) loadRegistrations();
        else renderRegistrations();
    } else if (view === 'attendance') {
        document.getElementById('view-attendance').classList.add('active');
        loadAttendance();
    } else {
        document.getElementById('view-overview').classList.add('active');
        loadOverview();
    }
}

// ── OVERVIEW ────────────────────────────────────────────────
async function loadOverview() {
    try {
        const [stats, att] = await Promise.all([
            fetch('{{ route("admin.stats") }}').then(r => r.json()),
            fetch('{{ route("admin.attendance") }}').then(r => r.json()),
        ]);

        document.getElementById('ov-today').textContent    = stats.today_attendance;
        document.getElementById('ov-pending').textContent  = stats.pending;
        document.getElementById('ov-approved').textContent = stats.approved;
        document.getElementById('ov-total').textContent    = stats.total;
        document.getElementById('pendingBadge').textContent= stats.pending;

        renderTodayTable(att);
    } catch(e) {
        document.getElementById('todayAttendanceBody').innerHTML = '<div class="empty-state"><div>Failed to load.</div></div>';
    }
}

function renderTodayTable(data) {
    if (!data.length) {
        document.getElementById('todayAttendanceBody').innerHTML = `
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                No attendance recorded today.
            </div>`;
        return;
    }
    document.getElementById('todayAttendanceBody').innerHTML = `
        <table>
            <thead><tr><th>#</th><th>Name</th><th>Student No.</th><th>Course</th><th>Time In</th></tr></thead>
            <tbody>${data.map((r,i) => `
                <tr>
                    <td style="color:var(--text-muted);font-size:12px;">${i+1}</td>
                    <td><div class="person-cell"><div class="avatar">${initials(r.name)}</div><span style="font-weight:600;">${r.name}</span></div></td>
                    <td><code style="font-family:'DM Mono',monospace;font-size:12px;">${r.student_number}</code></td>
                    <td>${r.course ?? '—'}</td>
                    <td><span class="time-chip">${r.time_in}</span></td>
                </tr>`).join('')}
            </tbody>
        </table>`;
}

// ── REGISTRATIONS ───────────────────────────────────────────
async function loadRegistrations() {
    document.getElementById('regTableBody').innerHTML = '<div class="loading-state"><span class="spinner"></span></div>';
    try {
        allRegistrations = await fetch('{{ route("admin.registrations") }}').then(r => r.json());
        updateRegStats();
        renderRegistrations();
    } catch(e) {
        document.getElementById('regTableBody').innerHTML = '<div class="empty-state"><div>Failed to load.</div></div>';
    }
}

function updateRegStats() {
    const p = allRegistrations.filter(r => r.status === 'pending').length;
    document.getElementById('reg-pending').textContent  = p;
    document.getElementById('reg-approved').textContent = allRegistrations.filter(r => r.status === 'approved').length;
    document.getElementById('reg-total').textContent    = allRegistrations.length;
    document.getElementById('pendingBadge').textContent = p;
}

function renderRegistrations() {
    const search = document.getElementById('regSearch').value.toLowerCase();
    const role   = document.getElementById('roleFilter').value;
    const campus = document.getElementById('campusFilter').value;

    let data = allRegistrations.filter(r => {
        if (currentRegFilter !== 'all' && r.status !== currentRegFilter) return false;
        if (role   && r.role   !== role)   return false;
        if (campus && r.campus !== campus) return false;
        if (search && ![r.name, r.email, r.student_number].some(f => (f||'').toLowerCase().includes(search))) return false;
        return true;
    });

    document.getElementById('regTableTitle').textContent = viewTitles[currentRegFilter] + ` (${data.length})`;

    if (!data.length) {
        document.getElementById('regTableBody').innerHTML = `
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                No registrations found.
            </div>`;
        return;
    }

    document.getElementById('regTableBody').innerHTML = `
        <table>
            <thead><tr><th>Name</th><th>Role</th><th>Student No.</th><th>Campus</th><th>Course</th><th>Status</th><th>Registered</th><th>Actions</th></tr></thead>
            <tbody>${data.map(r => `
                <tr>
                    <td><div class="person-cell"><div class="avatar">${initials(r.name)}</div><div><div style="font-weight:600;">${r.name}</div><div style="font-size:11px;color:var(--text-muted);">${r.email}</div></div></div></td>
                    <td><span class="badge ${r.role}">${r.role}</span></td>
                    <td><code style="font-family:'DM Mono',monospace;font-size:12px;">${r.student_number ?? '—'}</code></td>
                    <td style="font-size:12px;">${r.campus ?? '—'}</td>
                    <td style="font-size:12px;">${r.course ?? '—'}</td>
                    <td><span class="badge ${r.status}">${r.status}</span></td>
                    <td style="font-size:11px;color:var(--text-muted);">${fmtDate(r.created_at)}</td>
                    <td>
                        <div class="action-btns">
                            <button class="btn-view" onclick='openModal(${JSON.stringify(r)})'>View</button>
                            ${r.status === 'pending' ? `
                            <button class="btn-approve" onclick="updateStatus(${r.id},'approved')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            </button>
                            <button class="btn-reject" onclick="updateStatus(${r.id},'rejected')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            </button>` : ''}
                        </div>
                    </td>
                </tr>`).join('')}
            </tbody>
        </table>`;
}

async function updateStatus(id, status) {
    try {
        const res  = await fetch(`/admin/registrations/${id}/status`, {
            method : 'PATCH',
            headers: { 'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}' },
            body   : JSON.stringify({ status }),
        });
        const data = await res.json();
        if (data.success) {
            const rec = allRegistrations.find(r => r.id === id);
            if (rec) rec.status = status;
            updateRegStats(); renderRegistrations();
            showToast(status === 'approved' ? '✅ Account approved!' : '❌ Registration rejected.');
            closeModal();
        } else showToast(data.message ?? 'Action failed.', true);
    } catch(e) { showToast('Network error.', true); }
}

// ── DAILY ATTENDANCE ────────────────────────────────────────
async function loadAttendance() {
    document.getElementById('attTableBody').innerHTML = '<div class="loading-state"><span class="spinner"></span></div>';
    const date   = document.getElementById('attDate').value;
    const search = document.getElementById('attSearch').value;
    try {
        const data = await fetch(`{{ route("admin.attendance") }}?date=${date}&search=${encodeURIComponent(search)}`).then(r => r.json());
        document.getElementById('attCount').textContent = `${data.length} record${data.length !== 1 ? 's' : ''}`;

        if (!data.length) {
            document.getElementById('attTableBody').innerHTML = `
                <div class="empty-state">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    No attendance records for this date.
                </div>`;
            return;
        }

        document.getElementById('attTableBody').innerHTML = `
            <table>
                <thead><tr><th>#</th><th>Name</th><th>Student No.</th><th>Course</th><th>Time In</th></tr></thead>
                <tbody>${data.map((r,i) => `
                    <tr>
                        <td style="color:var(--text-muted);font-size:12px;">${i+1}</td>
                        <td><div class="person-cell"><div class="avatar">${initials(r.name)}</div><span style="font-weight:600;">${r.name}</span></div></td>
                        <td><code style="font-family:'DM Mono',monospace;font-size:12px;">${r.student_number}</code></td>
                        <td>${r.course ?? '—'}</td>
                        <td><span class="time-chip">${r.time_in}</span></td>
                    </tr>`).join('')}
                </tbody>
            </table>`;
    } catch(e) {
        document.getElementById('attTableBody').innerHTML = '<div class="empty-state"><div>Failed to load.</div></div>';
    }
}

// ── MODAL ───────────────────────────────────────────────────
function openModal(r) {
    modalRecord = r;
    document.getElementById('modalBody').innerHTML = `
        <div class="modal-row"><span class="lbl">Full Name</span><span>${r.name}</span></div>
        <div class="modal-row"><span class="lbl">Email</span><span style="font-size:12px;">${r.email}</span></div>
        <div class="modal-row"><span class="lbl">Phone</span><span>${r.phone ?? '—'}</span></div>
        <div class="modal-row"><span class="lbl">Role</span><span class="badge ${r.role}">${r.role}</span></div>
        <div class="modal-row"><span class="lbl">Student No.</span><span style="font-family:'DM Mono',monospace;font-size:12px;">${r.student_number ?? '—'}</span></div>
        <div class="modal-row"><span class="lbl">Campus</span><span>${r.campus ?? '—'}</span></div>
        <div class="modal-row"><span class="lbl">Course</span><span>${r.course ?? '—'}</span></div>
        <div class="modal-row"><span class="lbl">Year Level</span><span>${r.year_level ?? '—'}</span></div>
        <div class="modal-row"><span class="lbl">Status</span><span class="badge ${r.status}">${r.status}</span></div>
        <div class="modal-row"><span class="lbl">Registered</span><span>${fmtDate(r.created_at)}</span></div>
    `;
    const isPending = r.status === 'pending';
    document.getElementById('modalApprove').style.display = isPending ? 'flex' : 'none';
    document.getElementById('modalReject').style.display  = isPending ? 'flex' : 'none';
    document.getElementById('viewModal').classList.add('open');
}
function closeModal()        { document.getElementById('viewModal').classList.remove('open'); }
function approveFromModal()  { if (modalRecord) updateStatus(modalRecord.id, 'approved'); }
function rejectFromModal()   { if (modalRecord) updateStatus(modalRecord.id, 'rejected'); }

document.getElementById('viewModal').addEventListener('click', e => { if (e.target === e.currentTarget) closeModal(); });

// ── HELPERS ─────────────────────────────────────────────────
function initials(name) { return (name||'?').split(' ').slice(0,2).map(w=>w[0]).join('').toUpperCase(); }
function fmtDate(d)     { return d ? new Date(d).toLocaleDateString('en-PH',{month:'short',day:'numeric',year:'numeric'}) : '—'; }

function showToast(msg, isErr = false) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.className   = 'toast' + (isErr ? ' error' : '');
    setTimeout(() => t.classList.add('show'), 10);
    setTimeout(() => t.classList.remove('show'), 3000);
}

// ── INIT ─────────────────────────────────────────────────────
loadOverview();
</script>
</body>
</html>