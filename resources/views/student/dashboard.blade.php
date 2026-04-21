<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - UCC LabTech</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/UCC_Logo.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green-dark:  #1a4d2e;
            --green-mid:   #2d6a4f;
            --green-main:  #2e7d32;
            --green-light: #4caf50;
            --green-pale:  #e8f5e9;
            --green-border:#c8e6c9;
            --orange:      #fb8c00;
            --orange-pale: #fff8e1;
            --red:         #e53935;
            --red-pale:    #fff5f5;
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
        .sidebar { width: var(--sidebar-w); background: var(--green-dark); color: var(--white); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; bottom: 0; z-index: 100; }
        .sidebar-logo { padding: 18px 20px; display: flex; align-items: center; gap: 12px; border-bottom: 1px solid rgba(255,255,255,.1); }
        .logo-box { width: 36px; height: 36px; background: var(--white); border-radius: 8px; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0; }
        .logo-box img { width: 30px; height: 30px; object-fit: contain; }
        .sidebar-logo .brand { font-weight: 700; font-size: 14px; }
        .sidebar-logo small { font-size: 10px; opacity: .55; display: block; }

        /* PROFILE IN SIDEBAR */
        .sidebar-profile { padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,.08); display: flex; align-items: center; gap: 10px; }
        .sidebar-avatar-wrap { position: relative; flex-shrink: 0; cursor: pointer; }
        .sidebar-avatar {
            width: 42px; height: 42px; border-radius: 50%;
            background: rgba(255,255,255,.15);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 15px; overflow: hidden;
            border: 2px solid rgba(255,255,255,.2);
            transition: border-color .2s;
        }
        .sidebar-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .sidebar-avatar-wrap:hover .sidebar-avatar { border-color: rgba(255,255,255,.6); }
        .avatar-edit-hint {
            position: absolute; bottom: -2px; right: -2px;
            width: 16px; height: 16px; background: var(--green-light);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            border: 2px solid var(--green-dark);
        }
        .avatar-edit-hint svg { width: 8px; height: 8px; color: var(--white); }
        .user-name { font-size: 13px; font-weight: 600; }
        .user-role { font-size: 10px; opacity: .55; text-transform: capitalize; }

        .sidebar-nav { padding: 12px 0; flex: 1; overflow-y: auto; }
        .nav-section { padding: 0 12px; }
        .nav-section-title { font-size: 10px; font-weight: 700; letter-spacing: 1px; opacity: .35; text-transform: uppercase; margin: 14px 0 5px 4px; }
        .nav-link { display: flex; align-items: center; gap: 10px; padding: 9px 12px; border-radius: 8px; font-size: 13px; font-weight: 500; color: rgba(255,255,255,.7); text-decoration: none; cursor: pointer; transition: all .2s; margin-bottom: 2px; background: none; border: none; width: 100%; text-align: left; }
        .nav-link:hover  { background: rgba(255,255,255,.08); color: var(--white); }
        .nav-link.active { background: rgba(255,255,255,.15); color: var(--white); }
        .nav-link svg { width: 16px; height: 16px; flex-shrink: 0; }
        .sidebar-footer { padding: 14px 20px; border-top: 1px solid rgba(255,255,255,.08); font-size: 11px; opacity: .4; }

        /* MAIN */
        .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; }
        .topbar { background: var(--white); border-bottom: 1px solid #e8e8e8; padding: 14px 28px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
        .topbar-left h1 { font-size: 18px; font-weight: 700; }
        .topbar-left .sub { font-size: 12px; color: var(--text-muted); margin-top: 1px; }

        .today-badge { display: flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .today-badge.logged     { background: var(--green-pale); color: var(--green-main); border: 1px solid var(--green-border); }
        .today-badge.not-logged { background: var(--orange-pale); color: var(--orange); border: 1px solid #ffe082; }
        .today-badge svg { width: 13px; height: 13px; }

        .content { padding: 24px 28px; }

        /* VIEWS */
        .view { display: none; }
        .view.active { display: block; }

        /* STAT GRID */
        .stat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; }
        .stat-card { background: var(--white); border-radius: 14px; padding: 20px 22px; box-shadow: 0 2px 8px rgba(0,0,0,.06); display: flex; align-items: center; gap: 16px; }
        .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .stat-icon svg { width: 22px; height: 22px; }
        .stat-icon.green  { background: var(--green-pale); color: var(--green-main); }
        .stat-icon.orange { background: var(--orange-pale); color: var(--orange); }
        .stat-icon.blue   { background: var(--blue-pale); color: var(--blue); }
        .stat-label { font-size: 12px; color: var(--text-muted); font-weight: 500; }
        .stat-value { font-size: 26px; font-weight: 700; line-height: 1.1; }
        .stat-sub   { font-size: 11px; color: var(--text-muted); margin-top: 2px; }

        /* CARDS */
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .card { background: var(--white); border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,.06); overflow: hidden; }
        .card-head { padding: 16px 20px; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; justify-content: space-between; }
        .card-head h2 { font-size: 14px; font-weight: 700; }
        .card-body { padding: 20px; }

        /* PROFILE CARD */
        .profile-header { background: linear-gradient(135deg, var(--green-dark), var(--green-main)); padding: 28px 20px 20px; text-align: center; color: var(--white); position: relative; }

        .profile-pic-wrap {
            position: relative; width: 80px; height: 80px;
            margin: 0 auto 12px; cursor: pointer;
        }
        .profile-pic {
            width: 80px; height: 80px; border-radius: 50%;
            background: rgba(255,255,255,.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 28px; font-weight: 700; overflow: hidden;
            border: 3px solid rgba(255,255,255,.4);
            transition: all .2s;
        }
        .profile-pic img { width: 100%; height: 100%; object-fit: cover; }
        .profile-pic-wrap:hover .profile-pic { border-color: rgba(255,255,255,.9); }
        .profile-pic-overlay {
            position: absolute; inset: 0; border-radius: 50%;
            background: rgba(0,0,0,.45); display: flex; flex-direction: column;
            align-items: center; justify-content: center; gap: 2px;
            opacity: 0; transition: opacity .2s; color: var(--white);
            font-size: 10px; font-weight: 600;
        }
        .profile-pic-overlay svg { width: 18px; height: 18px; }
        .profile-pic-wrap:hover .profile-pic-overlay { opacity: 1; }

        .profile-name { font-size: 16px; font-weight: 700; }
        .profile-role { font-size: 12px; opacity: .75; margin-top: 2px; text-transform: capitalize; }

        /* Profile picture action buttons */
        .pic-actions { display: flex; gap: 8px; justify-content: center; margin-top: 12px; }
        .pic-btn {
            padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 600;
            cursor: pointer; border: none; display: flex; align-items: center; gap: 4px;
            transition: all .2s;
        }
        .pic-btn.change { background: rgba(255,255,255,.2); color: var(--white); }
        .pic-btn.change:hover { background: rgba(255,255,255,.35); }
        .pic-btn.remove { background: rgba(229,57,53,.3); color: #ffcdd2; }
        .pic-btn.remove:hover { background: rgba(229,57,53,.5); }
        .pic-btn svg { width: 11px; height: 11px; }

        .profile-info { padding: 16px 20px; }
        .info-row { display: flex; align-items: center; gap: 10px; padding: 10px 0; border-bottom: 1px solid #f5f5f5; font-size: 13px; }
        .info-row:last-child { border-bottom: none; }
        .info-row svg { width: 15px; height: 15px; color: var(--green-main); flex-shrink: 0; }
        .info-row .lbl { color: var(--text-muted); font-size: 11px; width: 90px; flex-shrink: 0; }
        .info-row .val { font-weight: 500; }

        .status-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .status-badge.approved { background: var(--green-pale); color: var(--green-main); }
        .status-badge.pending  { background: var(--orange-pale); color: var(--orange); }
        .status-badge.rejected { background: var(--red-pale); color: var(--red); }

        /* CALENDAR */
        .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px; }
        .cal-header { text-align: center; font-size: 10px; font-weight: 700; color: var(--text-muted); padding: 4px 0; }
        .cal-day { aspect-ratio: 1; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 500; color: var(--text-muted); }
        .cal-day.has-attendance { background: var(--green-main); color: var(--white); font-weight: 700; }
        .cal-day.today { border: 2px solid var(--green-main); color: var(--green-main); font-weight: 700; }
        .cal-day.today.has-attendance { background: var(--green-main); color: var(--white); border-color: var(--green-dark); }
        .cal-day.empty { opacity: 0; pointer-events: none; }

        /* HISTORY TABLE */
        .history-table { width: 100%; border-collapse: collapse; }
        .history-table th { text-align: left; font-size: 10px; font-weight: 700; letter-spacing: .5px; text-transform: uppercase; color: var(--text-muted); padding: 8px 14px; border-bottom: 1px solid #f0f0f0; background: #fafafa; }
        .history-table td { padding: 11px 14px; font-size: 13px; border-bottom: 1px solid #f8f8f8; }
        .history-table tr:last-child td { border-bottom: none; }
        .history-table tr:hover td { background: #fafff9; }

        .time-chip { font-family: 'DM Mono', monospace; font-size: 11px; padding: 3px 8px; border-radius: 6px; display: inline-block; }
        .time-chip.in  { background: var(--green-pale); color: var(--green-main); }
        .time-chip.out { background: var(--blue-pale); color: var(--blue); }
        .time-chip.none { background: #f5f5f5; color: #bbb; }

        .empty-state { text-align: center; padding: 32px; color: var(--text-muted); font-size: 13px; }
        .empty-state svg { width: 36px; height: 36px; margin: 0 auto 8px; display: block; opacity: .3; }

        .export-btn {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--green-main); color: var(--white);
            border: none; border-radius: 8px; padding: 8px 16px;
            font-family: inherit; font-size: 12px; font-weight: 600;
            text-decoration: none; cursor: pointer; transition: background .2s;
        }
        .export-btn:hover { background: var(--green-mid); }
        .export-btn svg { width: 14px; height: 14px; }

        /* UPLOAD MODAL */
        .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.5); display: none; align-items: center; justify-content: center; z-index: 200; padding: 16px; }
        .modal-overlay.open { display: flex; }
        .modal { background: var(--white); border-radius: 16px; width: 100%; max-width: 400px; overflow: hidden; box-shadow: 0 12px 40px rgba(0,0,0,.18); }
        .modal-head { background: linear-gradient(135deg, var(--green-dark), var(--green-main)); color: var(--white); padding: 18px 20px; display: flex; align-items: center; justify-content: space-between; }
        .modal-head h3 { font-size: 15px; font-weight: 700; }
        .modal-close { background: rgba(255,255,255,.15); border: none; color: var(--white); border-radius: 6px; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .modal-close:hover { background: rgba(255,255,255,.25); }
        .modal-close svg { width: 14px; height: 14px; }
        .modal-body { padding: 24px; }

        .upload-zone {
            border: 2px dashed var(--green-border); border-radius: 12px;
            padding: 32px 20px; text-align: center; cursor: pointer;
            transition: all .2s; background: #fafafa;
        }
        .upload-zone:hover { border-color: var(--green-main); background: var(--green-pale); }
        .upload-zone.drag-over { border-color: var(--green-main); background: var(--green-pale); }
        .upload-zone svg { width: 36px; height: 36px; color: var(--green-main); margin-bottom: 8px; opacity: .6; }
        .upload-zone p { font-size: 13px; color: var(--text-muted); }
        .upload-zone strong { color: var(--green-main); }

        .preview-wrap { display: none; text-align: center; margin-bottom: 16px; }
        .preview-wrap img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid var(--green-border); }

        .modal-btns { display: flex; gap: 8px; margin-top: 16px; }
        .btn-primary { flex: 1; background: var(--green-main); color: var(--white); border: none; border-radius: 8px; padding: 11px; font-family: inherit; font-size: 14px; font-weight: 600; cursor: pointer; transition: background .2s; }
        .btn-primary:hover { background: var(--green-mid); }
        .btn-primary:disabled { opacity: .6; cursor: not-allowed; }
        .btn-secondary { background: var(--white); color: var(--text-mid); border: 1.5px solid #e0e0e0; border-radius: 8px; padding: 11px 16px; font-family: inherit; font-size: 14px; cursor: pointer; }
        .btn-secondary:hover { border-color: var(--green-border); }

        .toast { position: fixed; bottom: 24px; right: 24px; background: var(--green-dark); color: var(--white); padding: 12px 20px; border-radius: 10px; font-size: 13px; font-weight: 500; box-shadow: 0 4px 16px rgba(0,0,0,.2); transform: translateY(80px); opacity: 0; transition: all .3s; z-index: 999; }
        .toast.show  { transform: translateY(0); opacity: 1; }
        .toast.error { background: var(--red); }

        @media (max-width: 900px) {
            .stat-grid { grid-template-columns: 1fr 1fr; }
            .grid-2    { grid-template-columns: 1fr; }
            .sidebar   { transform: translateX(-100%); }
            .main      { margin-left: 0; }
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-box">
            <img src="{{ asset('images/UCC_Logo.png') }}" alt="UCC"
                 onerror="this.style.display='none';this.parentElement.innerHTML='<span style=\'font-weight:700;font-size:10px;color:#2e7d32;\'>UCC</span>'">
        </div>
        <div>
            <div class="brand">UCC LabTech</div>
            <small>Attendance System</small>
        </div>
    </div>

    <div class="sidebar-profile">
        <div class="sidebar-avatar-wrap" onclick="openUploadModal()">
            <div class="sidebar-avatar" id="sidebarAvatar">
                @if($user->profile_picture)
                    <img src="{{ Storage::url($user->profile_picture) }}" alt="Profile">
                @else
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                @endif
            </div>
            <div class="avatar-edit-hint">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </div>
        </div>
        <div>
            <div class="user-name">{{ Str::limit($user->name, 16) }}</div>
            <div class="user-role">{{ $user->role }}</div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">
            <div class="nav-section-title">My Account</div>
            <button class="nav-link active" onclick="setView('overview', this)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Dashboard
            </button>
            <button class="nav-link" onclick="setView('logs', this)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                Attendance Logs
            </button>
            <a class="nav-link" href="{{ route('home') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Attendance Page
            </a>

            <div class="nav-section-title">Account</div>
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
        <div class="topbar-left">
            <h1 id="pageTitle">My Dashboard</h1>
            <div class="sub">{{ now()->format('l, F d, Y') }}</div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;">
            @if($todayLogged)
                <div class="today-badge logged">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Attendance logged today
                </div>
            @else
                <div class="today-badge not-logged">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Not yet logged today
                </div>
            @endif
        </div>
    </div>

    <div class="content">

        <!-- ══ OVERVIEW VIEW ══ -->
        <div class="view active" id="view-overview">
            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-icon green">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <div>
                        <div class="stat-label">This Month</div>
                        <div class="stat-value">{{ $records->count() }}</div>
                        <div class="stat-sub">Days attended</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon orange">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div>
                        <div class="stat-label">Last Attendance</div>
                        <div class="stat-value" style="font-size:16px;margin-top:2px;">
                            {{ $records->first() ? \Carbon\Carbon::parse($records->first()->created_at)->format('M d') : '—' }}
                        </div>
                        <div class="stat-sub">{{ $records->first() ? $records->first()->time_in : 'No record yet' }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    </div>
                    <div>
                        <div class="stat-label">Account Status</div>
                        <div class="stat-value" style="font-size:15px;margin-top:4px;">
                            <span class="status-badge {{ $user->status }}">{{ ucfirst($user->status) }}</span>
                        </div>
                        <div class="stat-sub">{{ ucfirst($user->role) }}</div>
                    </div>
                </div>
            </div>

            <div class="grid-2">
                <!-- Profile Card -->
                <div class="card">
                    <div class="profile-header">
                        <div class="profile-pic-wrap" onclick="openUploadModal()">
                            <div class="profile-pic" id="profilePicMain">
                                @if($user->profile_picture)
                                    <img src="{{ Storage::url($user->profile_picture) }}" alt="Profile" id="profileImg">
                                @else
                                    <span id="profileInitials">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                @endif
                            </div>
                            <div class="profile-pic-overlay">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                Change Photo
                            </div>
                        </div>
                        <div class="profile-name">{{ $user->name }}</div>
                        <div class="profile-role">{{ $user->role }}</div>
                        <div class="pic-actions">
                            <button class="pic-btn change" onclick="openUploadModal()">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Change Photo
                            </button>
                            @if($user->profile_picture)
                            <button class="pic-btn remove" onclick="removePhoto()">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                                Remove
                            </button>
                            @endif
                        </div>
                    </div>
                    <div class="profile-info">
                        @if($student)
                        <div class="info-row">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                            <span class="lbl">Student No.</span>
                            <span class="val" style="font-family:'DM Mono',monospace;font-size:12px;">{{ $student->student_number }}</span>
                        </div>
                        <div class="info-row">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span class="lbl">Campus</span>
                            <span class="val">{{ $student->campus ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/></svg>
                            <span class="lbl">Course</span>
                            <span class="val">{{ $student->course ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/></svg>
                            <span class="lbl">Year Level</span>
                            <span class="val">{{ $student->year_level ?? '—' }}</span>
                        </div>
                        @endif
                        <div class="info-row">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            <span class="lbl">Email</span>
                            <span class="val" style="font-size:12px;">{{ $user->email }}</span>
                        </div>
                        <div class="info-row">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81"/></svg>
                            <span class="lbl">Phone</span>
                            <span class="val">{{ $user->phone ?? '—' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Calendar -->
                <div class="card">
                    <div class="card-head">
                        <h2>Attendance Calendar</h2>
                        <span style="font-size:12px;color:var(--text-muted);">{{ now()->format('F Y') }}</span>
                    </div>
                    <div class="card-body">
                        @php
                            $attendedDays = $records->filter(fn($r) => \Carbon\Carbon::parse($r->created_at)->month === now()->month)->map(fn($r) => \Carbon\Carbon::parse($r->created_at)->day)->toArray();
                            $firstDay     = now()->startOfMonth()->dayOfWeek;
                            $daysInMonth  = now()->daysInMonth;
                            $today        = now()->day;
                        @endphp
                        <div class="calendar-grid">
                            @foreach(['Su','Mo','Tu','We','Th','Fr','Sa'] as $h)
                                <div class="cal-header">{{ $h }}</div>
                            @endforeach
                            @for($i = 0; $i < $firstDay; $i++)
                                <div class="cal-day empty">·</div>
                            @endfor
                            @for($d = 1; $d <= $daysInMonth; $d++)
                                <div class="cal-day {{ in_array($d, $attendedDays) ? 'has-attendance' : '' }} {{ $d === $today ? 'today' : '' }}">{{ $d }}</div>
                            @endfor
                        </div>
                        <div style="margin-top:14px;display:flex;gap:16px;font-size:11px;color:var(--text-muted);">
                            <span style="display:flex;align-items:center;gap:5px;"><span style="width:12px;height:12px;border-radius:3px;background:var(--green-main);display:inline-block;"></span>Attended</span>
                            <span style="display:flex;align-items:center;gap:5px;"><span style="width:12px;height:12px;border-radius:3px;border:2px solid var(--green-main);display:inline-block;"></span>Today</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent 10 -->
            <div class="card">
                <div class="card-head">
                    <h2>Recent Attendance</h2>
                    <button class="nav-link" style="width:auto;color:var(--green-main);font-size:12px;padding:4px 8px;" onclick="setView('logs', document.querySelector('[onclick*=logs]'))">View all logs →</button>
                </div>
                @if($records->count())
                <table class="history-table">
                    <thead><tr><th>#</th><th>Date</th><th>Day</th><th>Time In</th><th>Time Out</th></tr></thead>
                    <tbody>
                        @foreach($records->take(10) as $i => $rec)
                        <tr>
                            <td style="color:var(--text-muted);font-size:11px;">{{ $i+1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($rec->created_at)->format('M d, Y') }}</td>
                            <td style="color:var(--text-muted);">{{ \Carbon\Carbon::parse($rec->created_at)->format('l') }}</td>
                            <td><span class="time-chip in">{{ $rec->time_in ?? '—' }}</span></td>
                            <td>@if($rec->time_out)<span class="time-chip out">{{ $rec->time_out }}</span>@else<span class="time-chip none">—</span>@endif</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    No attendance records yet.
                </div>
                @endif
            </div>
        </div>

        <!-- ══ LOGS VIEW ══ -->
        <div class="view" id="view-logs">
            <div class="card">
                <div class="card-head">
                    <h2>Full Attendance Logs</h2>
                    <a href="{{ route('student.export_pdf') }}" target="_blank" class="export-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        Export to PDF
                    </a>
                </div>
                @if($records->count())
                <table class="history-table">
                    <thead>
                        <tr><th>#</th><th>Date</th><th>Day</th><th>Time In</th><th>Time Out</th><th>Duration</th></tr>
                    </thead>
                    <tbody>
                        @foreach($records as $i => $rec)
                        @php
                            $duration = '—';
                            if ($rec->time_in && $rec->time_out) {
                                try {
                                    $in  = \Carbon\Carbon::createFromFormat('h:i:s A', $rec->time_in,  'Asia/Manila');
                                    $out = \Carbon\Carbon::createFromFormat('h:i:s A', $rec->time_out, 'Asia/Manila');
                                    $mins = $in->diffInMinutes($out);
                                    $duration = floor($mins/60).'h '.($mins%60).'m';
                                } catch(\Exception $e) { $duration = '—'; }
                            }
                        @endphp
                        <tr>
                            <td style="color:var(--text-muted);font-size:11px;">{{ $i+1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($rec->created_at)->format('M d, Y') }}</td>
                            <td style="color:var(--text-muted);">{{ \Carbon\Carbon::parse($rec->created_at)->format('l') }}</td>
                            <td><span class="time-chip in">{{ $rec->time_in ?? '—' }}</span></td>
                            <td>@if($rec->time_out)<span class="time-chip out">{{ $rec->time_out }}</span>@else<span class="time-chip none">—</span>@endif</td>
                            <td style="font-size:12px;color:var(--text-muted);">{{ $duration }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    No attendance records found.
                </div>
                @endif
            </div>
        </div>

    </div>
</div>

<!-- UPLOAD MODAL -->
<div class="modal-overlay" id="uploadModal">
    <div class="modal">
        <div class="modal-head">
            <h3>Change Profile Picture</h3>
            <button class="modal-close" onclick="closeUploadModal()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="modal-body">
            <div class="preview-wrap" id="previewWrap">
                <img id="previewImg" src="" alt="Preview">
                <p style="font-size:12px;color:var(--text-muted);margin-top:8px;">Preview</p>
            </div>

            <div class="upload-zone" id="uploadZone" onclick="document.getElementById('fileInput').click()"
                 ondragover="event.preventDefault();this.classList.add('drag-over')"
                 ondragleave="this.classList.remove('drag-over')"
                 ondrop="handleDrop(event)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                <p><strong>Click to upload</strong> or drag & drop</p>
                <p style="margin-top:4px;font-size:11px;">JPG, PNG, GIF, WebP — max 3MB</p>
            </div>
            <input type="file" id="fileInput" accept="image/*" style="display:none" onchange="previewFile(this)">

            <div class="modal-btns">
                <button class="btn-secondary" onclick="closeUploadModal()">Cancel</button>
                <button class="btn-primary" id="uploadBtn" onclick="uploadPhoto()" disabled>Upload Photo</button>
            </div>
        </div>
    </div>
</div>

<div class="toast" id="toast"></div>

<script>
let selectedFile = null;

// ── VIEW SWITCHING ──────────────────────────────────────────
function setView(view, btn) {
    document.querySelectorAll('.view').forEach(v => v.classList.remove('active'));
    document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
    document.getElementById('view-' + view).classList.add('active');
    if (btn) btn.classList.add('active');
    const titles = { overview: 'My Dashboard', logs: 'Attendance Logs' };
    document.getElementById('pageTitle').textContent = titles[view] ?? 'Dashboard';
}

// ── PROFILE PICTURE ─────────────────────────────────────────
function openUploadModal()  { document.getElementById('uploadModal').classList.add('open'); }
function closeUploadModal() { document.getElementById('uploadModal').classList.remove('open'); selectedFile = null; document.getElementById('previewWrap').style.display = 'none'; document.getElementById('uploadBtn').disabled = true; document.getElementById('fileInput').value = ''; }

function previewFile(input) {
    const file = input.files[0];
    if (!file) return;
    if (file.size > 3 * 1024 * 1024) { showToast('File too large. Max 3MB.', true); return; }
    selectedFile = file;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('previewImg').src = e.target.result;
        document.getElementById('previewWrap').style.display = 'block';
        document.getElementById('uploadBtn').disabled = false;
    };
    reader.readAsDataURL(file);
}

function handleDrop(e) {
    e.preventDefault();
    document.getElementById('uploadZone').classList.remove('drag-over');
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        const dt = new DataTransfer();
        dt.items.add(file);
        document.getElementById('fileInput').files = dt.files;
        previewFile(document.getElementById('fileInput'));
    }
}

async function uploadPhoto() {
    if (!selectedFile) return;
    const btn  = document.getElementById('uploadBtn');
    btn.disabled   = true;
    btn.textContent = 'Uploading...';

    const formData = new FormData();
    formData.append('profile_picture', selectedFile);
    formData.append('_token', '{{ csrf_token() }}');

    try {
        const res  = await fetch('{{ route("profile.picture") }}', { method:'POST', body: formData });
        const data = await res.json();
        if (data.success) {
            // Update all avatar instances
            const newImg = `<img src="${data.url}?t=${Date.now()}" alt="Profile" id="profileImg" style="width:100%;height:100%;object-fit:cover;">`;
            document.getElementById('profilePicMain').innerHTML  = newImg;
            document.getElementById('sidebarAvatar').innerHTML   = newImg;
            closeUploadModal();
            showToast('✅ ' + data.message);
            setTimeout(() => location.reload(), 1200);
        } else {
            showToast(data.message ?? 'Upload failed.', true);
        }
    } catch(e) {
        showToast('Network error.', true);
    }

    btn.disabled    = false;
    btn.textContent = 'Upload Photo';
}

async function removePhoto() {
    if (!confirm('Remove your profile picture?')) return;
    try {
        const res  = await fetch('{{ route("profile.picture.remove") }}', {
            method : 'DELETE',
            headers: { 'X-CSRF-TOKEN':'{{ csrf_token() }}', 'Accept':'application/json' },
        });
        const data = await res.json();
        if (data.success) {
            showToast('✅ Profile picture removed.');
            setTimeout(() => location.reload(), 1000);
        }
    } catch(e) {
        showToast('Network error.', true);
    }
}

document.getElementById('uploadModal').addEventListener('click', function(e) {
    if (e.target === this) closeUploadModal();
});

// ── TOAST ───────────────────────────────────────────────────
function showToast(msg, isErr = false) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.className   = 'toast' + (isErr ? ' error' : '');
    setTimeout(() => t.classList.add('show'), 10);
    setTimeout(() => t.classList.remove('show'), 3000);
}
</script>
</body>
</html>