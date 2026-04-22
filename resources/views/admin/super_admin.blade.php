<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - UCC LabTech</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/UCC_Logo.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green-dark:   #1a4d2e;
            --green-mid:    #2d6a4f;
            --green-main:   #2e7d32;
            --green-light:  #4caf50;
            --green-pale:   #e8f5e9;
            --green-border: #c8e6c9;
            --red:          #e53935;
            --red-pale:     #fff5f5;
            --orange:       #fb8c00;
            --orange-pale:  #fff8e1;
            --blue:         #1565c0;
            --blue-pale:    #e3f2fd;
            --purple:       #6a1b9a;
            --purple-pale:  #f3e5f5;
            --text-dark:    #1b1b1b;
            --text-mid:     #4a4a4a;
            --text-muted:   #888;
            --white:        #ffffff;
            --bg:           #f4f6f4;
            --sidebar-w:    245px;
            --shadow:       0 2px 8px rgba(0,0,0,.07);
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
        }

        /* ════════════════════════════════════════
           SIDEBAR
        ════════════════════════════════════════ */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--green-dark);
            color: var(--white);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
            overflow-y: auto;
        }

        .sidebar-logo {
            padding: 18px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,.1);
            flex-shrink: 0;
        }
        .logo-box {
            width: 38px; height: 38px;
            background: var(--white);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden; flex-shrink: 0;
        }
        .logo-box img { width: 30px; height: 30px; object-fit: contain; }
        .sidebar-logo .brand { font-weight: 700; font-size: 14px; line-height: 1.2; }
        .sidebar-logo small   { font-size: 10px; opacity: .5; display: block; }

        .sidebar-user {
            padding: 14px 20px;
            border-bottom: 1px solid rgba(255,255,255,.08);
            display: flex; align-items: center; gap: 10px;
            flex-shrink: 0;
        }
        .user-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: rgba(255,255,255,.15);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 13px; flex-shrink: 0;
        }
        .user-name { font-size: 13px; font-weight: 600; line-height: 1.2; }
        .user-role { font-size: 10px; opacity: .5; }

        .sidebar-nav { padding: 10px 0; flex: 1; }
        .nav-section  { padding: 0 12px; }
        .nav-section-title {
            font-size: 9px; font-weight: 700;
            letter-spacing: 1.2px; opacity: .35;
            text-transform: uppercase;
            margin: 16px 0 5px 4px;
        }
        .nav-link {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 12px; border-radius: 8px;
            font-size: 13px; font-weight: 500;
            color: rgba(255,255,255,.68);
            text-decoration: none; cursor: pointer;
            transition: all .18s; margin-bottom: 1px;
            background: none; border: none; width: 100%; text-align: left;
        }
        .nav-link:hover  { background: rgba(255,255,255,.08); color: var(--white); }
        .nav-link.active { background: rgba(255,255,255,.15); color: var(--white); font-weight: 600; }
        .nav-link svg    { width: 15px; height: 15px; flex-shrink: 0; }
        .nav-badge {
            margin-left: auto;
            background: var(--red); color: var(--white);
            font-size: 10px; font-weight: 700;
            padding: 2px 7px; border-radius: 10px;
            min-width: 18px; text-align: center;
        }

        .sidebar-footer {
            padding: 14px 20px;
            border-top: 1px solid rgba(255,255,255,.08);
            font-size: 11px; opacity: .35;
            flex-shrink: 0;
        }

        /* ════════════════════════════════════════
           MAIN LAYOUT
        ════════════════════════════════════════ */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .topbar {
            background: var(--white);
            border-bottom: 1px solid #e6ebe6;
            padding: 13px 28px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar h1  { font-size: 17px; font-weight: 700; }
        .topbar .sub { font-size: 11px; color: var(--text-muted); margin-top: 1px; }
        .admin-pill {
            display: flex; align-items: center; gap: 6px;
            background: var(--green-pale);
            border: 1px solid var(--green-border);
            border-radius: 20px; padding: 5px 14px;
            font-size: 11px; font-weight: 700; color: var(--green-main);
        }
        .admin-pill svg { width: 12px; height: 12px; }

        .content { padding: 22px 28px; }

        /* ════════════════════════════════════════
           VIEWS
        ════════════════════════════════════════ */
        .view { display: none; }
        .view.active { display: block; }

        /* ════════════════════════════════════════
           STAT CARDS
        ════════════════════════════════════════ */
        .stat-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 14px; margin-bottom: 22px; }
        .stat-grid.cols-3 { grid-template-columns: repeat(3,1fr); }

        .stat-card {
            background: var(--white); border-radius: 12px;
            padding: 18px 20px; box-shadow: var(--shadow);
            display: flex; align-items: center; gap: 14px;
        }
        .stat-icon {
            width: 44px; height: 44px; border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .stat-icon svg { width: 20px; height: 20px; }
        .stat-icon.green  { background: var(--green-pale); color: var(--green-main); }
        .stat-icon.orange { background: var(--orange-pale); color: var(--orange); }
        .stat-icon.red    { background: var(--red-pale); color: var(--red); }
        .stat-icon.blue   { background: var(--blue-pale); color: var(--blue); }
        .stat-icon.purple { background: var(--purple-pale); color: var(--purple); }
        .stat-label { font-size: 11px; color: var(--text-muted); font-weight: 500; }
        .stat-value { font-size: 26px; font-weight: 700; line-height: 1; margin: 3px 0; }
        .stat-sub   { font-size: 11px; color: var(--text-muted); }

        /* ════════════════════════════════════════
           FILTER BAR
        ════════════════════════════════════════ */
        .filter-bar {
            background: var(--white); border-radius: 12px;
            padding: 12px 18px; margin-bottom: 14px;
            display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
            box-shadow: var(--shadow);
        }
        .filter-input {
            flex: 1; min-width: 200px;
            border: 1.5px solid #e0e0e0; border-radius: 8px;
            padding: 8px 12px; font-family: inherit; font-size: 13px;
            color: var(--text-dark); outline: none; background: #fafafa;
        }
        .filter-input:focus { border-color: var(--green-main); background: var(--white); }
        .filter-select {
            border: 1.5px solid #e0e0e0; border-radius: 8px;
            padding: 8px 12px; font-family: inherit; font-size: 13px;
            outline: none; background: var(--white); cursor: pointer;
            color: var(--text-dark);
        }
        .filter-select:focus { border-color: var(--green-main); }

        /* ════════════════════════════════════════
           TABLE CARD
        ════════════════════════════════════════ */
        .table-card {
            background: var(--white); border-radius: 12px;
            box-shadow: var(--shadow); overflow: hidden;
            margin-bottom: 20px;
        }
        .table-head {
            padding: 13px 20px;
            display: flex; align-items: center; justify-content: space-between;
            border-bottom: 1px solid #f0f0f0;
        }
        .table-head h2 { font-size: 13px; font-weight: 700; }

        .refresh-btn {
            border: 1.5px solid var(--green-border);
            background: var(--green-pale); color: var(--green-main);
            border-radius: 8px; padding: 5px 13px;
            font-family: inherit; font-size: 12px; font-weight: 600;
            cursor: pointer; display: flex; align-items: center; gap: 5px;
            transition: background .18s;
        }
        .refresh-btn:hover { background: var(--green-border); }
        .refresh-btn svg   { width: 13px; height: 13px; }

        table { width: 100%; border-collapse: collapse; }
        th {
            text-align: left; font-size: 10px; font-weight: 700;
            letter-spacing: .5px; text-transform: uppercase;
            color: var(--text-muted); padding: 9px 18px;
            border-bottom: 1px solid #f0f0f0; background: #fafafa;
        }
        td {
            padding: 11px 18px; font-size: 13px;
            border-bottom: 1px solid #f7f7f7;
            vertical-align: middle;
        }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fafff9; }

        /* ════════════════════════════════════════
           PERSON CELL
        ════════════════════════════════════════ */
        .person-cell { display: flex; align-items: center; gap: 10px; }
        .avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--green-pale); color: var(--green-main);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 12px; flex-shrink: 0;
            overflow: hidden;
        }
        .avatar img { width: 100%; height: 100%; object-fit: cover; }
        .person-name  { font-weight: 600; font-size: 13px; }
        .person-email { font-size: 11px; color: var(--text-muted); margin-top: 1px; }

        /* ════════════════════════════════════════
           BADGES
        ════════════════════════════════════════ */
        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 9px; border-radius: 20px;
            font-size: 11px; font-weight: 600;
        }
        .badge.student     { background: var(--blue-pale);   color: var(--blue); }
        .badge.staff       { background: var(--purple-pale);  color: var(--purple); }
        .badge.practicumer { background: #fff3e0;             color: #e65100; }
        .badge.team-leader { background: #fce4ec;             color: #880e4f; }
        .badge.super_admin { background: #e8eaf6;             color: #283593; }
        .badge.pending     { background: var(--orange-pale);  color: var(--orange); }
        .badge.approved    { background: var(--green-pale);   color: var(--green-main); }
        .badge.rejected    { background: var(--red-pale);     color: var(--red); }
        .badge.active      { background: var(--green-pale);   color: var(--green-main); }
        .badge.inactive    { background: #f5f5f5;             color: #9e9e9e; }

        /* ════════════════════════════════════════
           ACTION BUTTONS
        ════════════════════════════════════════ */
        .action-btns { display: flex; gap: 5px; flex-wrap: wrap; }

        .btn-approve {
            background: var(--green-main); color: var(--white);
            border: none; border-radius: 6px; padding: 5px 10px;
            font-family: inherit; font-size: 11px; font-weight: 600;
            cursor: pointer; display: inline-flex; align-items: center; gap: 4px;
            transition: background .18s; white-space: nowrap;
        }
        .btn-approve:hover { background: var(--green-mid); }

        .btn-reject {
            background: var(--white); color: var(--red);
            border: 1.5px solid #ffcdd2; border-radius: 6px; padding: 5px 10px;
            font-family: inherit; font-size: 11px; font-weight: 600;
            cursor: pointer; display: inline-flex; align-items: center; gap: 4px;
            transition: all .18s; white-space: nowrap;
        }
        .btn-reject:hover { background: var(--red-pale); }

        .btn-revert {
            background: var(--white); color: var(--orange);
            border: 1.5px solid #ffe082; border-radius: 6px; padding: 5px 10px;
            font-family: inherit; font-size: 11px; font-weight: 600;
            cursor: pointer; display: inline-flex; align-items: center; gap: 4px;
            transition: all .18s; white-space: nowrap;
        }
        .btn-revert:hover { background: var(--orange-pale); }

        .btn-deactivate {
            background: var(--white); color: #5d4037;
            border: 1.5px solid #d7ccc8; border-radius: 6px; padding: 5px 10px;
            font-family: inherit; font-size: 11px; font-weight: 600;
            cursor: pointer; display: inline-flex; align-items: center; gap: 4px;
            transition: all .18s; white-space: nowrap;
        }
        .btn-deactivate:hover { background: #efebe9; }

        .btn-activate {
            background: var(--blue-pale); color: var(--blue);
            border: 1.5px solid #90caf9; border-radius: 6px; padding: 5px 10px;
            font-family: inherit; font-size: 11px; font-weight: 600;
            cursor: pointer; display: inline-flex; align-items: center; gap: 4px;
            transition: all .18s; white-space: nowrap;
        }
        .btn-activate:hover { background: #bbdefb; }

        .btn-view {
            background: var(--white); color: var(--text-mid);
            border: 1.5px solid #e0e0e0; border-radius: 6px; padding: 5px 10px;
            font-family: inherit; font-size: 11px; cursor: pointer;
            transition: all .18s;
        }
        .btn-view:hover { border-color: var(--green-border); color: var(--green-main); }

        .btn-approve svg, .btn-reject svg, .btn-revert svg,
        .btn-deactivate svg, .btn-activate svg { width: 11px; height: 11px; }

        /* ════════════════════════════════════════
           TIME CHIP
        ════════════════════════════════════════ */
        .time-chip {
            font-family: 'DM Mono', monospace; font-size: 11px;
            padding: 3px 8px; border-radius: 6px; display: inline-block;
        }
        .time-chip.in   { background: var(--green-pale); color: var(--green-main); }
        .time-chip.out  { background: var(--blue-pale);  color: var(--blue); }
        .time-chip.none { background: #f5f5f5; color: #bbb; }

        /* ════════════════════════════════════════
           EMPTY / LOADING STATES
        ════════════════════════════════════════ */
        .empty-state {
            text-align: center; padding: 48px 20px;
            color: var(--text-muted); font-size: 13px;
        }
        .empty-state svg {
            width: 38px; height: 38px;
            margin: 0 auto 10px; display: block; opacity: .25;
        }
        .loading-state { text-align: center; padding: 40px; color: var(--text-muted); font-size: 13px; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .spinner {
            display: inline-block; width: 18px; height: 18px;
            border: 2px solid var(--green-border);
            border-top-color: var(--green-main);
            border-radius: 50%; animation: spin .8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ════════════════════════════════════════
           MODAL
        ════════════════════════════════════════ */
        .modal-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,.45);
            display: none; align-items: center; justify-content: center;
            z-index: 200; padding: 16px;
        }
        .modal-overlay.open { display: flex; }
        .modal {
            background: var(--white); border-radius: 16px;
            width: 100%; max-width: 460px;
            box-shadow: 0 12px 40px rgba(0,0,0,.18);
            overflow: hidden;
        }
        .modal-header {
            background: linear-gradient(135deg, var(--green-dark), var(--green-main));
            color: var(--white); padding: 18px 22px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .modal-header h3 { font-size: 15px; font-weight: 700; }
        .modal-close {
            background: rgba(255,255,255,.15); border: none;
            color: var(--white); border-radius: 6px;
            width: 28px; height: 28px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
        }
        .modal-close:hover { background: rgba(255,255,255,.25); }
        .modal-close svg   { width: 14px; height: 14px; }
        .modal-body { padding: 22px; }
        .modal-row {
            display: flex; gap: 10px; margin-bottom: 10px;
            font-size: 13px; align-items: flex-start;
        }
        .modal-row .lbl {
            font-weight: 700; font-size: 11px; color: var(--text-muted);
            text-transform: uppercase; letter-spacing: .4px;
            width: 110px; flex-shrink: 0; padding-top: 2px;
        }
        .modal-btns {
            display: flex; gap: 8px; margin-top: 20px;
            flex-wrap: wrap; align-items: center;
        }

        /* ════════════════════════════════════════
           SETTINGS — Day picker
        ════════════════════════════════════════ */
        .day-picker-label {
            display: flex; align-items: center; gap: 5px;
            padding: 6px 12px; border-radius: 8px;
            border: 1.5px solid #e0e0e0;
            font-size: 13px; cursor: pointer;
            transition: all .18s; user-select: none;
        }
        .day-picker-label input[type=checkbox] { accent-color: var(--green-main); cursor: pointer; }

        /* ════════════════════════════════════════
           TOAST
        ════════════════════════════════════════ */
        .toast {
            position: fixed; bottom: 24px; right: 24px;
            background: var(--green-dark); color: var(--white);
            padding: 12px 20px; border-radius: 10px;
            font-size: 13px; font-weight: 500;
            box-shadow: 0 4px 16px rgba(0,0,0,.2);
            transform: translateY(80px); opacity: 0;
            transition: all .3s; z-index: 999;
            max-width: 320px;
        }
        .toast.show  { transform: translateY(0); opacity: 1; }
        .toast.error { background: var(--red); }

        .alert.error   { background: var(--red-pale);   border: 1px solid #ffcdd2; color: var(--red);    display: block; }
        .alert.success { background: var(--green-pale);  border: 1px solid var(--green-border); color: var(--green-main); display: block; }

        /* ════════════════════════════════════════
           RESPONSIVE
        ════════════════════════════════════════ */
        @media (max-width: 1024px) { .stat-grid { grid-template-columns: repeat(2,1fr); } }
        @media (max-width: 768px)  { .sidebar { transform: translateX(-100%); } .main { margin-left: 0; } }
    </style>
</head>
<body>

<!-- ══════════════════════════════════════════════════════════
     SIDEBAR
══════════════════════════════════════════════════════════ -->
<aside class="sidebar">

    <div class="sidebar-logo">
        <div class="logo-box">
            <img src="{{ asset('images/UCC_Logo.png') }}" alt="UCC"
                 onerror="this.style.display='none';this.parentElement.innerHTML='<span style=\'font-weight:700;font-size:10px;color:#2e7d32;\'>UCC</span>'">
        </div>
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
            <button class="nav-link" onclick="setView('archived', this)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 8v13H3V8"/><path d="M23 3H1v5h22V3z"/><line x1="10" y1="12" x2="14" y2="12"/></svg>
                Archived / Rejected
            </button>

            <div class="nav-section-title">Settings</div>
            <button class="nav-link" onclick="setView('settings', this)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 010 14.14M4.93 4.93a10 10 0 000 14.14"/></svg>
                Office Hours & Controls
            </button>

            <div class="nav-section-title">System</div>
            <a class="nav-link" href="{{ route('home') }}" target="_blank" rel="noopener">
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

<!-- ══════════════════════════════════════════════════════════
     MAIN
══════════════════════════════════════════════════════════ -->
<div class="main">

    <div class="topbar">
        <div>
            <h1 id="pageTitle">Overview</h1>
            <div class="sub">{{ now('Asia/Manila')->format('l, F d, Y') }}</div>
        </div>
        <div class="admin-pill">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Super Admin
        </div>
    </div>

    <div class="content">

        <!-- ══ OVERVIEW ══════════════════════════════════════ -->
        <div class="view active" id="view-overview">
            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="23 11 17 11"/></svg>
                    </div>
                    <div>
                        <div class="stat-label">Today's Attendance</div>
                        <div class="stat-value" id="ov-today">—</div>
                        <div class="stat-sub">Students logged in</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon orange">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div>
                        <div class="stat-label">Pending Approvals</div>
                        <div class="stat-value" id="ov-pending">—</div>
                        <div class="stat-sub">Awaiting review</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <div>
                        <div class="stat-label">Approved Accounts</div>
                        <div class="stat-value" id="ov-approved">—</div>
                        <div class="stat-sub">Active members</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon purple">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                    </div>
                    <div>
                        <div class="stat-label">Total Registrations</div>
                        <div class="stat-value" id="ov-total">—</div>
                        <div class="stat-sub">All time</div>
                    </div>
                </div>
            </div>

            <div class="table-card">
                <div class="table-head">
                    <h2>Today's Attendance Log</h2>
                    <button class="refresh-btn" onclick="loadOverview()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.95"/></svg>
                        Refresh
                    </button>
                </div>
                <div id="todayAttBody">
                    <div class="loading-state"><span class="spinner"></span>&nbsp;Loading...</div>
                </div>
            </div>
        </div>

        <!-- ══ REGISTRATIONS ══════════════════════════════════ -->
        <div class="view" id="view-registrations">
            <div class="stat-grid cols-3">
                <div class="stat-card">
                    <div class="stat-icon orange"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                    <div><div class="stat-label">Pending</div><div class="stat-value" id="reg-pending">—</div></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div>
                    <div><div class="stat-label">Approved</div><div class="stat-value" id="reg-approved">—</div></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon purple"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
                    <div><div class="stat-label">Total</div><div class="stat-value" id="reg-total">—</div></div>
                </div>
            </div>

            <div class="filter-bar">
                <input class="filter-input" id="regSearch" type="text" placeholder="🔍  Search name, email or student number..." oninput="renderRegistrations()">
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
                <button class="refresh-btn" onclick="loadRegistrations()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.95"/></svg>
                    Refresh
                </button>
            </div>

            <div class="table-card">
                <div class="table-head">
                    <h2 id="regTableTitle">Registrations</h2>
                </div>
                <div id="regTableBody">
                    <div class="loading-state"><span class="spinner"></span>&nbsp;Loading...</div>
                </div>
            </div>
        </div>

        <!-- ══ DAILY ATTENDANCE ═══════════════════════════════ -->
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
                <div id="attTableBody">
                    <div class="loading-state"><span class="spinner"></span>&nbsp;Loading...</div>
                </div>
            </div>
        </div>

        <!-- ══ ARCHIVED ═══════════════════════════════════════ -->
        <div class="view" id="view-archived">
            <div class="table-card">
                <div class="table-head">
                    <h2>Archived / Rejected Students</h2>
                    <button class="refresh-btn" onclick="loadArchived()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.95"/></svg>
                        Refresh
                    </button>
                </div>
                <div id="archivedBody">
                    <div class="loading-state"><span class="spinner"></span>&nbsp;Loading...</div>
                </div>
            </div>
        </div>

        <!-- ══ SETTINGS ═══════════════════════════════════════ -->
        <div class="view" id="view-settings">

            <!-- Manual Toggle -->
            <div class="table-card" style="margin-bottom:20px;">
                <div class="table-head">
                    <h2>Manual Attendance Control</h2>
                    <span id="currentSystemStatus" style="font-size:12px;color:var(--text-muted);">Loading...</span>
                </div>
                <div style="padding:20px;display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
                    <button class="btn-approve" style="padding:10px 18px;font-size:13px;" onclick="toggleAttendance('open')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M18 8h1a4 4 0 010 8h-1"/><path d="M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
                        🟢 Force Open
                    </button>
                    <button class="btn-reject" style="padding:10px 18px;font-size:13px;" onclick="toggleAttendance('close')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        🔴 Force Close
                    </button>
                    <button class="btn-revert" style="padding:10px 18px;font-size:13px;" onclick="toggleAttendance('auto')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.95"/></svg>
                        🔄 Set to Automatic
                    </button>
                    <span style="font-size:12px;color:var(--text-muted);">
                        ⚠️ Sunday is always closed — cannot be overridden.
                    </span>
                </div>
            </div>

            <!-- Office Hours Config -->
            <div class="table-card">
                <div class="table-head">
                    <h2>Office Hours Configuration</h2>
                </div>
                <div style="padding:24px;max-width:580px;">

                    <div style="margin-bottom:20px;">
                        <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px;">Work Days</div>
                        <div style="display:flex;gap:8px;flex-wrap:wrap;" id="workDayPickers"></div>
                        <div style="font-size:11px;color:#e57373;margin-top:8px;">* Sunday is always excluded and cannot be selected.</div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
                        <div>
                            <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:7px;">Opening Time</div>
                            <input type="time" id="settingOpen" class="filter-input" style="width:100%;">
                        </div>
                        <div>
                            <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:7px;">Closing Time</div>
                            <input type="time" id="settingClose" class="filter-input" style="width:100%;">
                        </div>
                    </div>

                    <div style="margin-bottom:20px;">
                        <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:7px;">
                            Notice / Note
                            <span style="font-weight:400;text-transform:none;font-size:11px;color:var(--text-muted);">&nbsp;(shown to students when they click on office hours)</span>
                        </div>
                        <textarea id="settingNote" rows="3"
                            class="filter-input"
                            style="width:100%;resize:vertical;font-family:inherit;line-height:1.5;"
                            placeholder="e.g., Office hours changed as per the directive of the City Government of Caloocan."></textarea>
                    </div>

                    <button class="btn-approve" style="padding:11px 26px;font-size:14px;" onclick="saveOfficeHours()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="14" height="14"><polyline points="20 6 9 17 4 12"/></svg>
                        Save Office Hours
                    </button>
                </div>
            </div>
        </div>

    </div><!-- /content -->
</div><!-- /main -->

<!-- ══════════════════════════════════════════════════════════
     DETAIL MODAL
══════════════════════════════════════════════════════════ -->
<div class="modal-overlay" id="detailModal">
    <div class="modal">
        <div class="modal-header">
            <h3>Registration Details</h3>
            <button class="modal-close" onclick="closeModal()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="modal-body">
            <div id="modalBody"></div>
            <div class="modal-btns">
                <button class="btn-approve" id="modalApprove"  onclick="approveFromModal()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="11" height="11"><polyline points="20 6 9 17 4 12"/></svg>
                    Approve
                </button>
                <button class="btn-reject"  id="modalReject"   onclick="rejectFromModal()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="11" height="11"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Reject
                </button>
                <button class="btn-revert"  id="modalRevert"   onclick="revertFromModal()" style="display:none;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="11" height="11"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.95"/></svg>
                    Revert to Pending
                </button>
                <button class="btn-deactivate" id="modalDeactivate" onclick="deactivateFromModal()" style="display:none;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="11" height="11"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    Deactivate
                </button>
                <button class="btn-activate"   id="modalActivate"   onclick="activateFromModal()"   style="display:none;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="11" height="11"><path d="M18 8h1a4 4 0 010 8h-1"/><path d="M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8z"/></svg>
                    Activate
                </button>
                <button class="btn-view" onclick="closeModal()" style="margin-left:auto;">Close</button>
                <button class="btn-view" id="modalChangePassword"
                    style="color:var(--blue);border-color:#90caf9;"
                    onclick="openChangePasswordFromModal()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="11" height="11"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    Change Password
                </button>
            </div>
        </div>
    </div>
</div>

<!-- CHANGE PASSWORD MODAL -->
<div class="modal-overlay" id="changePasswordModal">
    <div class="modal">
        <div class="modal-header">
            <h3>Change Password — <span id="cpModalName"></span></h3>
            <button class="modal-close" onclick="closeChangePasswordModal()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert" id="cpAlert" style="padding:10px 14px;border-radius:8px;font-size:13px;margin-bottom:14px;display:none;"></div>

            <div style="margin-bottom:14px;">
                <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;">New Password</div>
                <input type="password" id="cpNewPassword" class="filter-input" style="width:100%;" placeholder="Enter new password (min. 8 characters)">
            </div>
            <div style="margin-bottom:20px;">
                <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;">Confirm New Password</div>
                <input type="password" id="cpConfirmPassword" class="filter-input" style="width:100%;" placeholder="Re-enter new password">
            </div>

            <div style="font-size:12px;color:var(--text-muted);background:#fafafa;border-radius:8px;padding:10px 12px;margin-bottom:16px;">
                ⚠️ The staff member will need to use this new password on their next login.
            </div>

            <div class="modal-btns">
                <button class="btn-approve" id="cpSubmitBtn" onclick="submitChangePassword()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="11" height="11"><polyline points="20 6 9 17 4 12"/></svg>
                    Change Password
                </button>
                <button class="btn-view" onclick="closeChangePasswordModal()" style="margin-left:auto;">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="toast" id="toast"></div>

<!-- ══════════════════════════════════════════════════════════
     JAVASCRIPT
══════════════════════════════════════════════════════════ -->
<script>
'use strict';

// ── STATE ───────────────────────────────────────────────────
let allRegistrations = [];
let currentView      = 'overview';
let currentRegFilter = 'all';
let modalRecord      = null;

// ── VIEW SWITCHING ──────────────────────────────────────────
const viewTitles = {
    overview:   'Overview',
    pending:    'Pending Approvals',
    all:        'All Registrations',
    approved:   'Approved',
    rejected:   'Rejected',
    attendance: 'Daily Attendance',
    archived:   'Archived / Rejected Students',
    settings:   'Office Hours & Controls',
};

function setView(view, btn) {
    currentView = view;

    document.querySelectorAll('.view').forEach(v => v.classList.remove('active'));
    document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));

    if (btn) btn.classList.add('active');
    document.getElementById('pageTitle').textContent = viewTitles[view] ?? view;

    const regViews = ['pending','all','approved','rejected'];

    if (regViews.includes(view)) {
        currentRegFilter = view;
        document.getElementById('view-registrations').classList.add('active');
        if (!allRegistrations.length) loadRegistrations();
        else renderRegistrations();

    } else if (view === 'attendance') {
        document.getElementById('view-attendance').classList.add('active');
        loadAttendance();

    } else if (view === 'archived') {
        document.getElementById('view-archived').classList.add('active');
        loadArchived();

    } else if (view === 'settings') {
        document.getElementById('view-settings').classList.add('active');
        loadSettingsView();

    } else {
        document.getElementById('view-overview').classList.add('active');
        loadOverview();
    }
}

// ── HELPERS ─────────────────────────────────────────────────
function initials(name) {
    return (name || '?').split(' ').slice(0, 2).map(w => w[0]).join('').toUpperCase();
}

function fmtDate(d) {
    if (!d) return '—';
    return new Date(d).toLocaleDateString('en-PH', { month:'short', day:'numeric', year:'numeric' });
}

function fmtDateTime(d) {
    if (!d) return '—';
    return new Date(d).toLocaleString('en-PH', { month:'short', day:'numeric', year:'numeric', hour:'numeric', minute:'2-digit', hour12:true });
}

function showToast(msg, isErr = false) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.className   = 'toast' + (isErr ? ' error' : '');
    setTimeout(() => t.classList.add('show'), 10);
    setTimeout(() => t.classList.remove('show'), 3200);
}

// ── OVERVIEW ────────────────────────────────────────────────
async function loadOverview() {
    try {
        const [stats, att] = await Promise.all([
            fetch('{{ route("admin.stats") }}').then(r => r.json()),
            fetch('{{ route("admin.attendance") }}').then(r => r.json()),
        ]);

        document.getElementById('ov-today').textContent    = stats.today_attendance ?? 0;
        document.getElementById('ov-pending').textContent  = stats.pending          ?? 0;
        document.getElementById('ov-approved').textContent = stats.approved         ?? 0;
        document.getElementById('ov-total').textContent    = stats.total            ?? 0;
        document.getElementById('pendingBadge').textContent= stats.pending          ?? 0;

        renderTodayTable(att);
    } catch(e) {
        document.getElementById('todayAttBody').innerHTML =
            '<div class="empty-state"><div>Failed to load overview.</div></div>';
    }
}

function renderTodayTable(data) {
    if (!data.length) {
        document.getElementById('todayAttBody').innerHTML = `
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                No attendance recorded today.
            </div>`;
        return;
    }
    document.getElementById('todayAttBody').innerHTML = `
        <table>
            <thead>
                <tr><th>#</th><th>Name</th><th>Student No.</th><th>Campus</th><th>Course</th><th>Time In</th><th>Time Out</th></tr>
            </thead>
            <tbody>
                ${data.map((r,i) => `
                    <tr>
                        <td style="color:var(--text-muted);font-size:11px;">${i+1}</td>
                        <td>
                            <div class="person-cell">
                                <div class="avatar">${initials(r.name)}</div>
                                <span style="font-weight:600;">${r.name}</span>
                            </div>
                        </td>
                        <td><code style="font-family:'DM Mono',monospace;font-size:11px;">${r.student_number}</code></td>
                        <td style="font-size:12px;">${r.campus ?? '—'}</td>
                        <td style="font-size:12px;">${r.course  ?? '—'}</td>
                        <td>${r.time_in  ? `<span class="time-chip in">${r.time_in}</span>`  : '<span class="time-chip none">—</span>'}</td>
                        <td>${r.time_out ? `<span class="time-chip out">${r.time_out}</span>` : '<span class="time-chip none">—</span>'}</td>
                    </tr>`).join('')}
            </tbody>
        </table>`;
}

// ── REGISTRATIONS ───────────────────────────────────────────
async function loadRegistrations() {
    document.getElementById('regTableBody').innerHTML =
        '<div class="loading-state"><span class="spinner"></span>&nbsp;Loading...</div>';
    try {
        allRegistrations = await fetch('{{ route("admin.registrations") }}').then(r => r.json());
        updateRegStats();
        renderRegistrations();
    } catch(e) {
        document.getElementById('regTableBody').innerHTML =
            '<div class="empty-state"><div>Failed to load registrations.</div></div>';
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
        if (search && ![r.name, r.email, r.student_number]
            .some(f => (f||'').toLowerCase().includes(search))) return false;
        return true;
    });

    document.getElementById('regTableTitle').textContent =
        (viewTitles[currentRegFilter] ?? 'Registrations') + ` (${data.length})`;

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
            <thead>
                <tr>
                    <th>Name</th><th>Role</th><th>Student No.</th>
                    <th>Campus</th><th>Course</th><th>Status</th>
                    <th>Active</th><th>Registered</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                ${data.map(r => `
                    <tr>
                        <td>
                            <div class="person-cell">
                                <div class="avatar">${initials(r.name)}</div>
                                <div>
                                    <div class="person-name">${r.name}</div>
                                    <div class="person-email">${r.email ?? ''}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge ${r.role}">${r.role}</span></td>
                        <td><code style="font-family:'DM Mono',monospace;font-size:11px;">${r.student_number ?? '—'}</code></td>
                        <td style="font-size:12px;">${r.campus ?? '—'}</td>
                        <td style="font-size:12px;">${r.course ?? '—'}</td>
                        <td><span class="badge ${r.status}">${r.status}</span></td>
                        <td>
                            ${r.status === 'approved'
                                ? `<span class="badge ${r.is_active ? 'active' : 'inactive'}">${r.is_active ? '● Active' : '○ Inactive'}</span>`
                                : '<span style="color:#ccc;font-size:12px;">—</span>'
                            }
                        </td>
                        <td style="font-size:11px;color:var(--text-muted);">${fmtDate(r.created_at)}</td>
                        <td>
                            <div class="action-btns">
                                <button class="btn-view" onclick='openModal(${JSON.stringify(r).replace(/'/g,"&#39;")})'>View</button>
                                <button class="btn-view" onclick='openChangePasswordModal(${r.id}, "${r.name.replace(/"/g,"&quot;")}")' title="Change Password" style="color:var(--blue);border-color:#90caf9;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="11" height="11"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                                    Password
                                </button>

                                ${r.status === 'pending' ? `
                                    <button class="btn-approve" onclick="updateStatus(${r.id},'approved')" title="Approve">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                    </button>
                                    <button class="btn-reject" onclick="updateStatus(${r.id},'rejected')" title="Reject">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    </button>
                                ` : ''}

                                ${r.status === 'rejected' ? `
                                    <button class="btn-approve" onclick="updateStatus(${r.id},'approved')" title="Approve directly">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                    </button>
                                    <button class="btn-revert" onclick="updateStatus(${r.id},'pending')" title="Revert to pending">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.95"/></svg>
                                    </button>
                                ` : ''}

                                ${r.status === 'approved' && r.role !== 'super_admin' ? `
                                    ${r.is_active
                                        ? `<button class="btn-deactivate" onclick="toggleActive(${r.id}, 0)" title="Deactivate">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                                           </button>`
                                        : `<button class="btn-activate" onclick="toggleActive(${r.id}, 1)" title="Activate">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8h1a4 4 0 010 8h-1"/><path d="M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8z"/></svg>
                                           </button>`
                                    }
                                ` : ''}
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
            headers: {
                'Content-Type':'application/json',
                'Accept':'application/json',
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },
            body: JSON.stringify({ status }),
        });
        const data = await res.json();
        if (data.success) {
            const rec = allRegistrations.find(r => r.id === id);
            if (rec) rec.status = status;
            updateRegStats();
            renderRegistrations();
            showToast(
                status === 'approved' ? '✅ Account approved!'  :
                status === 'rejected' ? '❌ Registration rejected.' :
                '🔄 Reverted to pending review.'
            );
            closeModal();
        } else {
            showToast(data.message ?? 'Action failed.', true);
        }
    } catch(e) {
        showToast('Network error. Please try again.', true);
    }
}

async function toggleActive(userId, isActive) {
    const label = isActive ? 'activate' : 'deactivate';
    if (!confirm(`Are you sure you want to ${label} this account?`)) return;
    try {
        const res  = await fetch(`/admin/users/${userId}/toggle-active`, {
            method : 'PATCH',
            headers: {
                'Content-Type':'application/json',
                'Accept':'application/json',
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },
            body: JSON.stringify({ is_active: isActive }),
        });
        const data = await res.json();
        if (data.success) {
            const rec = allRegistrations.find(r => r.id === userId);
            if (rec) rec.is_active = isActive;
            renderRegistrations();
            showToast(isActive ? '✅ Account activated!' : '🔒 Account deactivated.');
            closeModal();
        } else {
            showToast(data.message ?? 'Action failed.', true);
        }
    } catch(e) {
        showToast('Network error.', true);
    }
}

// ── DAILY ATTENDANCE ────────────────────────────────────────
async function loadAttendance() {
    document.getElementById('attTableBody').innerHTML =
        '<div class="loading-state"><span class="spinner"></span>&nbsp;Loading...</div>';
    const date   = document.getElementById('attDate').value;
    const search = document.getElementById('attSearch').value;
    try {
        const data = await fetch(
            `{{ route("admin.attendance") }}?date=${date}&search=${encodeURIComponent(search)}`
        ).then(r => r.json());

        document.getElementById('attCount').textContent =
            `${data.length} record${data.length !== 1 ? 's' : ''}`;

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
                <thead>
                    <tr><th>#</th><th>Name</th><th>Student No.</th><th>Campus</th><th>Course</th><th>Time In</th><th>Time Out</th></tr>
                </thead>
                <tbody>
                    ${data.map((r,i) => `
                        <tr>
                            <td style="color:var(--text-muted);font-size:11px;">${i+1}</td>
                            <td>
                                <div class="person-cell">
                                    <div class="avatar">${initials(r.name)}</div>
                                    <span style="font-weight:600;">${r.name}</span>
                                </div>
                            </td>
                            <td><code style="font-family:'DM Mono',monospace;font-size:11px;">${r.student_number}</code></td>
                            <td style="font-size:12px;">${r.campus ?? '—'}</td>
                            <td style="font-size:12px;">${r.course  ?? '—'}</td>
                            <td>${r.time_in  ? `<span class="time-chip in">${r.time_in}</span>`  : '<span class="time-chip none">—</span>'}</td>
                            <td>${r.time_out ? `<span class="time-chip out">${r.time_out}</span>` : '<span class="time-chip none">—</span>'}</td>
                        </tr>`).join('')}
                </tbody>
            </table>`;
    } catch(e) {
        document.getElementById('attTableBody').innerHTML =
            '<div class="empty-state"><div>Failed to load attendance data.</div></div>';
    }
}

// ── ARCHIVED ─────────────────────────────────────────────────
async function loadArchived() {
    document.getElementById('archivedBody').innerHTML =
        '<div class="loading-state"><span class="spinner"></span>&nbsp;Loading...</div>';
    try {
        const data = await fetch('{{ route("admin.archived") }}').then(r => r.json());

        if (!data.length) {
            document.getElementById('archivedBody').innerHTML = `
                <div class="empty-state">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 8v13H3V8"/><path d="M23 3H1v5h22V3z"/><line x1="10" y1="12" x2="14" y2="12"/></svg>
                    No archived students yet.
                </div>`;
            return;
        }

        document.getElementById('archivedBody').innerHTML = `
            <table>
                <thead>
                    <tr>
                        <th>Name</th><th>Role</th><th>Student No.</th>
                        <th>Campus</th><th>Course</th><th>Reason</th>
                        <th>Archived On</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    ${data.map(r => `
                        <tr>
                            <td>
                                <div class="person-cell">
                                    <div class="avatar">${initials(r.name)}</div>
                                    <div>
                                        <div class="person-name">${r.name}</div>
                                        <div class="person-email">${r.email ?? '—'}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge ${r.role}">${r.role}</span></td>
                            <td><code style="font-family:'DM Mono',monospace;font-size:11px;">${r.student_number}</code></td>
                            <td style="font-size:12px;">${r.campus ?? '—'}</td>
                            <td style="font-size:12px;">${r.course ?? '—'}</td>
                            <td><span class="badge rejected">${r.reason}</span></td>
                            <td style="font-size:11px;color:var(--text-muted);">${fmtDate(r.created_at)}</td>
                            <td>
                                <div class="action-btns">
                                    <button class="btn-approve" onclick="restoreArchived(${r.id},'approved')">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="11" height="11"><polyline points="20 6 9 17 4 12"/></svg>
                                        Approve
                                    </button>
                                    <button class="btn-revert" onclick="restoreArchived(${r.id},'pending')">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="11" height="11"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.95"/></svg>
                                        Revert to Pending
                                    </button>
                                </div>
                            </td>
                        </tr>`).join('')}
                </tbody>
            </table>`;
    } catch(e) {
        document.getElementById('archivedBody').innerHTML =
            '<div class="empty-state"><div>Failed to load archived records.</div></div>';
    }
}

async function restoreArchived(id, action) {
    const label = action === 'approved' ? 'approve and un-archive' : 'revert to pending';
    if (!confirm(`Are you sure you want to ${label} this student?`)) return;
    try {
        const res  = await fetch(`/admin/archived/${id}/restore`, {
            method : 'PATCH',
            headers: {
                'Content-Type':'application/json',
                'Accept':'application/json',
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },
            body: JSON.stringify({ action }),
        });
        const data = await res.json();
        if (data.success) {
            showToast(action === 'approved'
                ? '✅ Student approved and un-archived!'
                : '🔄 Student reverted to pending review!');
            allRegistrations = []; // force reload next visit
            loadArchived();
        } else {
            showToast(data.message ?? 'Action failed.', true);
        }
    } catch(e) {
        showToast('Network error.', true);
    }
}

// ── CHANGE PASSWORD (ADMIN) ──────────────────────────────────
let cpStudentId = null;

function openChangePasswordModal(studentId, name) {
    cpStudentId = studentId;
    document.getElementById('cpModalName').textContent  = name;
    document.getElementById('cpNewPassword').value      = '';
    document.getElementById('cpConfirmPassword').value  = '';
    document.getElementById('cpAlert').className        = 'alert';
    document.getElementById('changePasswordModal').classList.add('open');
}

function openChangePasswordFromModal() {
    if (!modalRecord) return;
    closeModal();
    openChangePasswordModal(modalRecord.id, modalRecord.name);
}

function closeChangePasswordModal() {
    document.getElementById('changePasswordModal').classList.remove('open');
    cpStudentId = null;
}

async function submitChangePassword() {
    const pw  = document.getElementById('cpNewPassword').value;
    const cpw = document.getElementById('cpConfirmPassword').value;
    const btn = document.getElementById('cpSubmitBtn');
    const alertEl = document.getElementById('cpAlert');

    alertEl.className = 'alert';

    if (pw.length < 8) {
        alertEl.textContent = 'Password must be at least 8 characters.';
        alertEl.className   = 'alert error';
        return;
    }
    if (pw !== cpw) {
        alertEl.textContent = 'Passwords do not match.';
        alertEl.className   = 'alert error';
        return;
    }

    btn.disabled    = true;
    btn.textContent = 'Changing...';

    try {
        const res  = await fetch(`/admin/users/${cpStudentId}/change-password`, {
            method : 'PATCH',
            headers: {
                'Content-Type':'application/json',
                'Accept':'application/json',
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },
            body: JSON.stringify({
                password:              pw,
                password_confirmation: cpw,
            }),
        });
        const data = await res.json();
        if (data.success) {
            alertEl.textContent = '✅ ' + data.message;
            alertEl.className   = 'alert success';
            setTimeout(() => closeChangePasswordModal(), 1800);
            showToast('✅ Password changed successfully!');
        } else {
            alertEl.textContent = data.message ?? 'Failed to change password.';
            alertEl.className   = 'alert error';
        }
    } catch(e) {
        alertEl.textContent = 'Network error. Please try again.';
        alertEl.className   = 'alert error';
    }

    btn.disabled    = false;
    btn.textContent = 'Change Password';
    // restore icon
    btn.innerHTML   = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="11" height="11"><polyline points="20 6 9 17 4 12"/></svg> Change Password`;
}

document.getElementById('changePasswordModal').addEventListener('click', function(e) {
    if (e.target === this) closeChangePasswordModal();
});

// ── MODAL ────────────────────────────────────────────────────
function openModal(r) {
    modalRecord = r;

    document.getElementById('modalBody').innerHTML = `
        <div class="modal-row"><span class="lbl">Full Name</span>   <span>${r.name}</span></div>
        <div class="modal-row"><span class="lbl">Email</span>        <span style="font-size:12px;">${r.email ?? '—'}</span></div>
        <div class="modal-row"><span class="lbl">Phone</span>        <span>${r.phone ?? '—'}</span></div>
        <div class="modal-row"><span class="lbl">Role</span>         <span><span class="badge ${r.role}">${r.role}</span></span></div>
        <div class="modal-row"><span class="lbl">Student No.</span>  <span style="font-family:'DM Mono',monospace;font-size:12px;">${r.student_number ?? '—'}</span></div>
        <div class="modal-row"><span class="lbl">Campus</span>       <span>${r.campus ?? '—'}</span></div>
        <div class="modal-row"><span class="lbl">Course</span>       <span>${r.course ?? '—'}</span></div>
        <div class="modal-row"><span class="lbl">Year Level</span>   <span>${r.year_level ?? '—'}</span></div>
        <div class="modal-row"><span class="lbl">Status</span>       <span><span class="badge ${r.status}">${r.status}</span></span></div>
        <div class="modal-row"><span class="lbl">Active</span>
            <span>
                ${r.status === 'approved'
                    ? `<span class="badge ${r.is_active ? 'active' : 'inactive'}">${r.is_active ? '● Active' : '○ Inactive'}</span>`
                    : '—'}
            </span>
        </div>
        <div class="modal-row"><span class="lbl">Registered</span>   <span>${fmtDate(r.created_at)}</span></div>
    `;

    // Show/hide buttons based on status
    document.getElementById('modalApprove').style.display    = (r.status === 'pending' || r.status === 'rejected') ? 'inline-flex' : 'none';
    document.getElementById('modalReject').style.display     = r.status === 'pending'  ? 'inline-flex' : 'none';
    document.getElementById('modalRevert').style.display     = r.status === 'rejected' ? 'inline-flex' : 'none';

    const isApprovable = r.status === 'approved' && r.role !== 'super_admin';
    document.getElementById('modalDeactivate').style.display = (isApprovable && r.is_active)  ? 'inline-flex' : 'none';
    document.getElementById('modalActivate').style.display   = (isApprovable && !r.is_active) ? 'inline-flex' : 'none';

    document.getElementById('detailModal').classList.add('open');

    // Add inside openModal() after existing button show/hide logic
    document.getElementById('modalChangePassword').style.display =
        r.role !== 'super_admin' ? 'inline-flex' : 'none';
}

function closeModal() { document.getElementById('detailModal').classList.remove('open'); }

function approveFromModal()    { if (modalRecord) updateStatus(modalRecord.id, 'approved'); }
function rejectFromModal()     { if (modalRecord) updateStatus(modalRecord.id, 'rejected'); }
function revertFromModal()     { if (modalRecord) updateStatus(modalRecord.id, 'pending');  }
function deactivateFromModal() { if (modalRecord) toggleActive(modalRecord.id, 0); }
function activateFromModal()   { if (modalRecord) toggleActive(modalRecord.id, 1); }

document.getElementById('detailModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

// ── SETTINGS ─────────────────────────────────────────────────
const DAY_NAMES = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

async function loadSettingsView() {
    try {
        const data = await fetch('{{ route("admin.office_hours.get") }}').then(r => r.json());

        const workDays = JSON.parse(data.work_days || '[1,2,3,4,5]');
        const picker   = document.getElementById('workDayPickers');

        picker.innerHTML = DAY_NAMES.map((name, i) => {
            if (i === 0) {
                return `<label class="day-picker-label" style="background:#fff5f5;border-color:#ffcdd2;color:#e57373;opacity:.6;cursor:not-allowed;">
                    <input type="checkbox" disabled> ${name} <small style="font-size:10px;">(always closed)</small>
                </label>`;
            }
            const checked = workDays.includes(i);
            return `<label class="day-picker-label" data-day="${i}"
                style="${checked ? 'border-color:var(--green-main);background:var(--green-pale);color:var(--green-main);font-weight:700;' : ''}">
                <input type="checkbox" value="${i}" ${checked ? 'checked' : ''}
                    onchange="updateDayLabel(this)"> ${name}
            </label>`;
        }).join('');

        document.getElementById('settingOpen').value  = data.time_open  ?? '08:00';
        document.getElementById('settingClose').value = data.time_close ?? '17:00';
        document.getElementById('settingNote').value  = data.note ?? '';

        // Current mode label
        const statusEl = document.getElementById('currentSystemStatus');
        if (statusEl) {
            let modeLabel = '🟡 Running on Schedule';
            if (data.is_manually_open)   modeLabel = '🔵 Manually Forced Open';
            if (data.is_manually_closed) modeLabel = '🟠 Manually Forced Closed';
            statusEl.textContent = `Current mode: ${modeLabel}` +
                (data.updated_by ? ` · Last updated by ${data.updated_by}` : '');
        }
    } catch(e) {
        console.error('Failed to load settings', e);
    }
}

function updateDayLabel(cb) {
    const label = cb.closest('label');
    if (!label) return;
    label.style.borderColor = cb.checked ? 'var(--green-main)' : '#e0e0e0';
    label.style.background  = cb.checked ? 'var(--green-pale)' : 'var(--white)';
    label.style.color       = cb.checked ? 'var(--green-main)' : 'var(--text-dark)';
    label.style.fontWeight  = cb.checked ? '700' : '500';
}

async function saveOfficeHours() {
    const checked   = [...document.querySelectorAll('#workDayPickers input[type=checkbox]:not([disabled]):checked')]
                        .map(cb => parseInt(cb.value));
    const timeOpen  = document.getElementById('settingOpen').value;
    const timeClose = document.getElementById('settingClose').value;
    const note      = document.getElementById('settingNote').value.trim();

    if (!checked.length)        { showToast('Please select at least one work day.', true); return; }
    if (!timeOpen || !timeClose){ showToast('Please set both opening and closing times.', true); return; }
    if (timeOpen >= timeClose)  { showToast('Closing time must be after opening time.', true); return; }

    try {
        const res  = await fetch('{{ route("admin.office_hours.save") }}', {
            method : 'POST',
            headers: {
                'Content-Type':'application/json',
                'Accept':'application/json',
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },
            body: JSON.stringify({ work_days: checked, time_open: timeOpen, time_close: timeClose, note }),
        });
        const data = await res.json();
        if (data.success) showToast('✅ Office hours saved successfully!');
        else showToast(data.message ?? 'Failed to save.', true);
    } catch(e) {
        showToast('Network error.', true);
    }
}

async function toggleAttendance(action) {
    const labels = { open:'force open', close:'force close', auto:'set to automatic' };
    if (!confirm(`Are you sure you want to ${labels[action]} the attendance system?`)) return;
    try {
        const res  = await fetch('{{ route("admin.attendance.toggle") }}', {
            method : 'POST',
            headers: {
                'Content-Type':'application/json',
                'Accept':'application/json',
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },
            body: JSON.stringify({ action }),
        });
        const data = await res.json();
        if (data.success) {
            showToast('✅ ' + data.message);
            loadSettingsView(); // refresh status label
        } else {
            showToast(data.message ?? 'Failed.', true);
        }
    } catch(e) {
        showToast('Network error.', true);
    }
}

// ── INIT ──────────────────────────────────────────────────────
loadOverview();
</script>

</body>
</html>