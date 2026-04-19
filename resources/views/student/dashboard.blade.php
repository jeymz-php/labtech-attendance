<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - UCC LabTech</title>
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
        .sidebar {
            width: var(--sidebar-w); background: var(--green-dark); color: var(--white);
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; bottom: 0; z-index: 100;
        }
        .sidebar-logo {
            padding: 22px 20px; display: flex; align-items: center; gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }
        .logo-box {
            width: 36px; height: 36px; background: var(--white); border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 11px; color: var(--green-main); flex-shrink: 0;
        }
        .sidebar-logo .brand { font-weight: 700; font-size: 14px; }
        .sidebar-logo small  { font-size: 10px; opacity: .55; display: block; }

        .sidebar-user {
            padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,.08);
            display: flex; align-items: center; gap: 10px;
        }
        .user-avatar {
            width: 38px; height: 38px; border-radius: 50%;
            background: rgba(255,255,255,.15); display: flex; align-items: center;
            justify-content: center; font-weight: 700; font-size: 14px; flex-shrink: 0;
        }
        .user-name  { font-size: 13px; font-weight: 600; }
        .user-role  { font-size: 10px; opacity: .55; text-transform: capitalize; }

        .sidebar-nav { padding: 12px 0; flex: 1; }
        .nav-section { padding: 0 12px; margin-bottom: 4px; }
        .nav-section-title { font-size: 10px; font-weight: 700; letter-spacing: 1px; opacity: .35; text-transform: uppercase; margin: 14px 0 5px 4px; }
        .nav-link {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: 8px;
            font-size: 13px; font-weight: 500; color: rgba(255,255,255,.7);
            text-decoration: none; cursor: pointer; transition: all .2s; margin-bottom: 2px;
        }
        .nav-link:hover  { background: rgba(255,255,255,.08); color: var(--white); }
        .nav-link.active { background: rgba(255,255,255,.15); color: var(--white); }
        .nav-link svg { width: 16px; height: 16px; flex-shrink: 0; }

        .sidebar-footer { padding: 14px 20px; border-top: 1px solid rgba(255,255,255,.08); font-size: 11px; opacity: .4; }

        /* MAIN */
        .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; }

        .topbar {
            background: var(--white); border-bottom: 1px solid #e8e8e8;
            padding: 14px 28px; display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar-left h1 { font-size: 18px; font-weight: 700; }
        .topbar-left .sub { font-size: 12px; color: var(--text-muted); margin-top: 1px; }
        .topbar-right { display: flex; align-items: center; gap: 10px; }

        .today-badge {
            display: flex; align-items: center; gap: 6px;
            padding: 7px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;
        }
        .today-badge.logged    { background: var(--green-pale); color: var(--green-main); border: 1px solid var(--green-border); }
        .today-badge.not-logged { background: var(--orange-pale); color: var(--orange); border: 1px solid #ffe082; }
        .today-badge svg { width: 13px; height: 13px; }

        .content { padding: 24px 28px; }

        /* STAT CARDS */
        .stat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; }
        .stat-card {
            background: var(--white); border-radius: 14px;
            padding: 20px 22px; box-shadow: 0 2px 8px rgba(0,0,0,.06);
            display: flex; align-items: center; gap: 16px;
        }
        .stat-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
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
        .profile-header {
            background: linear-gradient(135deg, var(--green-dark), var(--green-main));
            padding: 24px 20px; text-align: center; color: var(--white);
        }
        .profile-avatar {
            width: 64px; height: 64px; border-radius: 50%;
            background: rgba(255,255,255,.2); margin: 0 auto 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; font-weight: 700;
        }
        .profile-name { font-size: 16px; font-weight: 700; }
        .profile-role { font-size: 12px; opacity: .75; margin-top: 2px; text-transform: capitalize; }

        .profile-info { padding: 16px 20px; }
        .info-row { display: flex; align-items: center; gap: 10px; padding: 10px 0; border-bottom: 1px solid #f5f5f5; font-size: 13px; }
        .info-row:last-child { border-bottom: none; }
        .info-row svg { width: 15px; height: 15px; color: var(--green-main); flex-shrink: 0; }
        .info-row .lbl { color: var(--text-muted); font-size: 11px; width: 90px; flex-shrink: 0; }
        .info-row .val { font-weight: 500; }

        /* STATUS BADGE */
        .status-badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 600;
        }
        .status-badge.approved { background: var(--green-pale); color: var(--green-main); }
        .status-badge.pending  { background: var(--orange-pale); color: var(--orange); }
        .status-badge.rejected { background: var(--red-pale); color: var(--red); }

        /* CALENDAR */
        .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px; }
        .cal-header { text-align: center; font-size: 10px; font-weight: 700; color: var(--text-muted); padding: 4px 0; }
        .cal-day {
            aspect-ratio: 1; border-radius: 6px; display: flex; align-items: center;
            justify-content: center; font-size: 11px; font-weight: 500; color: var(--text-muted);
        }
        .cal-day.has-attendance { background: var(--green-main); color: var(--white); font-weight: 700; }
        .cal-day.today { border: 2px solid var(--green-main); color: var(--green-main); font-weight: 700; }
        .cal-day.today.has-attendance { background: var(--green-main); color: var(--white); border-color: var(--green-dark); }
        .cal-day.empty { opacity: 0; pointer-events: none; }
        .cal-month { font-size: 13px; font-weight: 700; margin-bottom: 10px; }

        /* HISTORY TABLE */
        .history-table { width: 100%; border-collapse: collapse; }
        .history-table th {
            text-align: left; font-size: 10px; font-weight: 700; letter-spacing: .5px;
            text-transform: uppercase; color: var(--text-muted);
            padding: 8px 12px; border-bottom: 1px solid #f0f0f0; background: #fafafa;
        }
        .history-table td { padding: 11px 12px; font-size: 13px; border-bottom: 1px solid #f8f8f8; }
        .history-table tr:last-child td { border-bottom: none; }
        .history-table tr:hover td { background: #fafff9; }

        .time-chip {
            font-family: 'DM Mono', monospace; font-size: 12px;
            background: var(--green-pale); color: var(--green-main);
            padding: 3px 8px; border-radius: 6px; display: inline-block;
        }

        .empty-state { text-align: center; padding: 32px; color: var(--text-muted); font-size: 13px; }
        .empty-state svg { width: 36px; height: 36px; margin-bottom: 8px; opacity: .3; display: block; margin-left: auto; margin-right: auto; }

        .spinner { display: inline-block; width: 16px; height: 16px; border: 2px solid var(--green-border); border-top-color: var(--green-main); border-radius: 50%; animation: spin .8s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }

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
        <div class="logo-box">UCC</div>
        <div>
            <div class="brand">UCC LabTech</div>
            <small>Attendance System</small>
        </div>
    </div>

    <div class="sidebar-user">
        <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
        <div>
            <div class="user-name">{{ Str::limit($user->name, 18) }}</div>
            <div class="user-role">{{ $user->role }}</div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">
            <div class="nav-section-title">My Account</div>
            <a class="nav-link active">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>
            <a class="nav-link" href="{{ route('home') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Attendance Page
            </a>
        </div>
        <div class="nav-section">
            <div class="nav-section-title">Account</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link" style="width:100%;background:none;border:none;text-align:left;cursor:pointer;">
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
            <h1>My Dashboard</h1>
            <div class="sub">{{ now()->format('l, F d, Y') }}</div>
        </div>
        <div class="topbar-right">
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

        <!-- Stats -->
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
                    <div class="profile-avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                    <div class="profile-name">{{ $user->name }}</div>
                    <div class="profile-role">{{ $user->role }}</div>
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
                        $attendedDays = $records
                            ->filter(fn($r) => \Carbon\Carbon::parse($r->created_at)->month === now()->month)
                            ->map(fn($r) => \Carbon\Carbon::parse($r->created_at)->day)
                            ->toArray();
                        $firstDay = now()->startOfMonth()->dayOfWeek;
                        $daysInMonth = now()->daysInMonth;
                        $today = now()->day;
                    @endphp

                    <div class="calendar-grid">
                        @foreach(['Su','Mo','Tu','We','Th','Fr','Sa'] as $h)
                            <div class="cal-header">{{ $h }}</div>
                        @endforeach
                        @for($i = 0; $i < $firstDay; $i++)
                            <div class="cal-day empty">·</div>
                        @endfor
                        @for($d = 1; $d <= $daysInMonth; $d++)
                            <div class="cal-day
                                {{ in_array($d, $attendedDays) ? 'has-attendance' : '' }}
                                {{ $d === $today ? 'today' : '' }}
                            ">{{ $d }}</div>
                        @endfor
                    </div>

                    <div style="margin-top:14px;display:flex;gap:16px;font-size:11px;color:var(--text-muted);">
                        <span style="display:flex;align-items:center;gap:5px;">
                            <span style="width:12px;height:12px;border-radius:3px;background:var(--green-main);display:inline-block;"></span>
                            Attended
                        </span>
                        <span style="display:flex;align-items:center;gap:5px;">
                            <span style="width:12px;height:12px;border-radius:3px;border:2px solid var(--green-main);display:inline-block;"></span>
                            Today
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance History -->
        <div class="card">
            <div class="card-head">
                <h2>Attendance History <span style="font-size:12px;color:var(--text-muted);font-weight:400;">(last 30 days)</span></h2>
                <span style="font-size:12px;color:var(--green-main);font-weight:600;">{{ $records->count() }} records</span>
            </div>
            @if($records->count())
            <table class="history-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Day</th>
                        <th>Time In</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records as $i => $rec)
                    <tr>
                        <td style="color:var(--text-muted);font-size:12px;">{{ $i + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($rec->created_at)->format('M d, Y') }}</td>
                        <td style="color:var(--text-muted);">{{ \Carbon\Carbon::parse($rec->created_at)->format('l') }}</td>
                        <td><span class="time-chip">{{ $rec->time_in }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                No attendance records in the last 30 days.
            </div>
            @endif
        </div>

    </div>
</div>

</body>
</html>