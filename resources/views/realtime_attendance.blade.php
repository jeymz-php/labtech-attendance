<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Attendance - UCC LabTech</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/UCC_Logo.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Mono:wght@500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green-dark:   #1a4d2e;
            --green-mid:    #2d6a4f;
            --green-main:   #2e7d32;
            --green-light:  #4caf50;
            --green-pale:   #e8f5e9;
            --green-border: #c8e6c9;
            --red-badge:    #e53935;
            --orange:       #fb8c00;
            --orange-pale:  #fff8e1;
            --blue:         #1565c0;
            --blue-pale:    #e3f2fd;
            --text-dark:    #1b1b1b;
            --text-mid:     #4a4a4a;
            --text-muted:   #888;
            --white:        #ffffff;
            --bg-page:      #f5f5f5;
            --radius:       14px;
            --shadow:       0 4px 24px rgba(0,0,0,.10);
        }
        body { font-family: 'DM Sans', sans-serif; background: var(--bg-page); min-height: 100vh; color: var(--text-dark); }

        /* ── HERO ── */
        .hero {
            background: linear-gradient(160deg, var(--green-dark) 0%, var(--green-main) 100%);
            color: var(--white); padding: 0 0 52px; position: relative; overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }
        .office-hours {
            background: rgba(0,0,0,.18); text-align: center; padding: 10px 16px;
            font-size: 13px; letter-spacing: .4px;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .office-hours svg { width: 14px; height: 14px; opacity: .8; }
        .hero-body { text-align: center; padding: 36px 24px 0; position: relative; }

        .school-logo {
            width: 84px; height: 84px; background: var(--white); border-radius: 18px;
            margin: 0 auto 20px; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 6px 24px rgba(0,0,0,.2); overflow: hidden;
        }
        .school-logo img { width: 68px; height: 68px; object-fit: contain; }

        .hero h1 { font-size: clamp(26px,5vw,36px); font-weight: 700; letter-spacing: -.5px; margin-bottom: 6px; }
        .hero .subtitle { font-size: 14px; opacity: .75; letter-spacing: .3px; }

        /* ── CLOCK ── */
        .clock-card {
            background: rgba(255,255,255,.12); backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,.18); border-radius: 50px;
            display: inline-flex; flex-direction: column; align-items: center;
            padding: 18px 44px 14px; margin-top: 28px;
        }
        .clock-time { font-family: 'DM Mono', monospace; font-size: clamp(30px,6vw,44px); font-weight: 500; letter-spacing: 2px; line-height: 1; }
        .clock-date { margin-top: 8px; font-size: 13px; opacity: .8; display: flex; align-items: center; gap: 10px; }
        .day-badge { background: var(--red-badge); color: var(--white); font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; letter-spacing: .5px; text-transform: uppercase; }

        /* ── MAIN ── */
        .main { max-width: 700px; margin: -28px auto 0; padding: 0 16px 60px; position: relative; z-index: 10; }

        .card { background: var(--white); border-radius: var(--radius); box-shadow: var(--shadow); padding: 24px; margin-bottom: 20px; }

        .section-label { font-size: 12px; font-weight: 700; color: var(--green-main); letter-spacing: .6px; text-transform: uppercase; display: flex; align-items: center; gap: 8px; margin-bottom: 16px; }
        .section-label svg { width: 15px; height: 15px; }

        /* ── INPUT ROW ── */
        .input-row { display: flex; gap: 10px; }
        .student-input {
            flex: 1; border: 1.5px solid var(--green-border); border-radius: 10px;
            padding: 13px 16px; font-family: inherit; font-size: 15px; color: var(--text-dark);
            outline: none; background: #fafafa; transition: border-color .2s, box-shadow .2s;
        }
        .student-input::placeholder { color: #bbb; }
        .student-input:focus { border-color: var(--green-main); box-shadow: 0 0 0 3px rgba(46,125,50,.12); background: var(--white); }
        .verify-btn {
            background: var(--green-main); color: var(--white); border: none; border-radius: 10px;
            padding: 13px 22px; font-family: inherit; font-size: 14px; font-weight: 700;
            cursor: pointer; display: flex; align-items: center; gap: 8px; transition: background .2s, transform .1s; white-space: nowrap;
        }
        .verify-btn:hover { background: var(--green-mid); }
        .verify-btn:active { transform: scale(.97); }
        .verify-btn:disabled { opacity: .6; cursor: not-allowed; }
        .verify-btn svg { width: 15px; height: 15px; }

        .status-msg { margin-top: 12px; font-size: 13px; color: var(--text-muted); display: flex; align-items: center; gap: 6px; }
        .status-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--green-light); display: inline-block; animation: pulse 2s infinite; }
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)}50%{opacity:.4;transform:scale(.85)} }

        /* ── RESULT PANELS ── */
        .result-panel { display: none; margin-top: 16px; border-radius: 12px; padding: 18px; border: 1.5px solid transparent; }
        .result-panel.show { display: block; }

        /* Time In */
        .result-panel.time-in  { background: #f1faf2; border-color: var(--green-border); }
        /* Time Out */
        .result-panel.time-out { background: var(--blue-pale); border-color: #90caf9; }
        /* Already done */
        .result-panel.already  { background: #f5f5f5; border-color: #e0e0e0; }
        /* Pending */
        .result-panel.pending  { background: var(--orange-pale); border-color: #ffe082; }
        /* Rejected */
        .result-panel.rejected { background: #fff5f5; border-color: #ffcdd2; }
        /* Not found */
        .result-panel.not-found { background: #fff5f5; border-color: #ffcdd2; }

        .result-icon { font-size: 20px; margin-bottom: 4px; }
        .result-title { font-weight: 700; font-size: 15px; margin-bottom: 4px; }
        .result-name  { font-weight: 600; font-size: 14px; }
        .result-meta  { font-size: 12px; color: var(--text-mid); margin-top: 3px; }
        .result-msg   { font-size: 13px; margin-top: 6px; }

        .timelog-row { display: flex; gap: 20px; margin-top: 12px; flex-wrap: wrap; }
        .timelog-item { display: flex; flex-direction: column; gap: 2px; }
        .timelog-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: var(--text-muted); }
        .timelog-value { font-family: 'DM Mono', monospace; font-size: 16px; font-weight: 600; }
        .timelog-value.in  { color: var(--green-main); }
        .timelog-value.out { color: var(--blue); }

        .register-hint { margin-top: 12px; font-size: 13px; color: var(--text-mid); }
        .register-link { color: var(--green-main); font-weight: 700; text-decoration: none; border-bottom: 1.5px solid var(--green-border); padding-bottom: 1px; }
        .register-link:hover { color: var(--green-mid); }

        .pending-note, .rejected-note {
            display: flex; align-items: flex-start; gap: 10px;
            margin-top: 8px; font-size: 13px; line-height: 1.6;
        }
        .pending-note svg  { color: var(--orange); width: 18px; height: 18px; flex-shrink: 0; margin-top: 1px; }
        .rejected-note svg { color: var(--red-badge); width: 18px; height: 18px; flex-shrink: 0; margin-top: 1px; }

        /* ── RECENT ACTIVITY ── */
        .activity-list { list-style: none; }
        .activity-item { display: flex; align-items: center; gap: 14px; padding: 11px 0; border-bottom: 1px solid #f0f0f0; }
        .activity-item:last-child { border-bottom: none; padding-bottom: 0; }
        .activity-item:first-child { padding-top: 0; }
        .avatar { width: 40px; height: 40px; border-radius: 50%; background: var(--green-pale); color: var(--green-main); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; flex-shrink: 0; }
        .activity-info { flex: 1; min-width: 0; }
        .activity-name { font-weight: 600; font-size: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .activity-detail { font-size: 11px; color: var(--text-muted); margin-top: 2px; }

        .time-chips { display: flex; gap: 6px; flex-direction: column; align-items: flex-end; }
        .time-chip { font-family: 'DM Mono', monospace; font-size: 11px; padding: 3px 8px; border-radius: 6px; white-space: nowrap; }
        .time-chip.in  { background: var(--green-pale); color: var(--green-main); }
        .time-chip.out { background: var(--blue-pale); color: var(--blue); }
        .time-chip.pending-chip { background: var(--orange-pale); color: var(--orange); }

        .loading-row { text-align: center; padding: 24px 0; color: var(--text-muted); font-size: 13px; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .spinner { width: 16px; height: 16px; border: 2px solid var(--green-border); border-top-color: var(--green-main); border-radius: 50%; animation: spin .8s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .empty-state { text-align: center; padding: 28px 0 12px; color: var(--text-muted); font-size: 13px; }
        .empty-state svg { width: 36px; height: 36px; margin-bottom: 8px; opacity: .3; display: block; margin-left: auto; margin-right: auto; }

        /* nav link */
        .hero-nav { position: absolute; top: 44px; right: 20px; z-index: 10; }
        .hero-nav a { color: rgba(255,255,255,.75); font-size: 12px; font-weight: 600; text-decoration: none; background: rgba(255,255,255,.12); padding: 6px 14px; border-radius: 20px; transition: background .2s; }
        .hero-nav a:hover { background: rgba(255,255,255,.22); color: var(--white); }

        /* ── OFFICE HOURS MODAL ── */
        .oh-modal-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,.45);
            display: none; align-items: center; justify-content: center;
            z-index: 300; padding: 16px;
        }
        .oh-modal-overlay.open { display: flex; }
        .oh-modal {
            background: var(--white); border-radius: 16px;
            width: 100%; max-width: 440px;
            box-shadow: 0 12px 40px rgba(0,0,0,.18);
            overflow: hidden;
        }
        .oh-modal-header {
            background: linear-gradient(135deg, var(--green-dark), var(--green-main));
            color: var(--white); padding: 18px 20px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .oh-modal-title { display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 15px; }
        .oh-modal-close { background: rgba(255,255,255,.15); border: none; color: var(--white); border-radius: 6px; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .oh-modal-close:hover { background: rgba(255,255,255,.25); }
        .oh-modal-close svg { width: 14px; height: 14px; }
        .oh-modal-body { padding: 20px; }

        .oh-row { display: flex; gap: 10px; padding: 10px 0; border-bottom: 1px solid #f0f0f0; font-size: 13px; align-items: flex-start; }
        .oh-row:last-child { border-bottom: none; }
        .oh-row .lbl { font-weight: 700; color: var(--text-muted); font-size: 11px; text-transform: uppercase; letter-spacing: .4px; width: 100px; flex-shrink: 0; padding-top: 1px; }
        .oh-row .val { color: var(--text-dark); line-height: 1.5; }

        .oh-status-open   { display: inline-block; background: var(--green-pale); color: var(--green-main); border: 1px solid var(--green-border); padding: 3px 12px; border-radius: 20px; font-weight: 700; font-size: 12px; }
        .oh-status-closed { display: inline-block; background: #fff5f5; color: var(--red-badge); border: 1px solid #ffcdd2; padding: 3px 12px; border-radius: 20px; font-weight: 700; font-size: 12px; }
        .oh-status-manual-open   { display: inline-block; background: var(--blue-pale); color: var(--blue); border: 1px solid #90caf9; padding: 3px 12px; border-radius: 20px; font-weight: 700; font-size: 12px; }
        .oh-status-manual-closed { display: inline-block; background: var(--orange-pale); color: var(--orange); border: 1px solid #ffe082; padding: 3px 12px; border-radius: 20px; font-weight: 700; font-size: 12px; }

        .oh-note {
            background: #fffde7; border: 1px solid #fff176;
            border-radius: 8px; padding: 12px 14px; margin-top: 14px;
            font-size: 13px; line-height: 1.6; color: #5d4037;
            display: flex; gap: 8px; align-items: flex-start;
        }
        .oh-note svg { width: 16px; height: 16px; color: #f9a825; flex-shrink: 0; margin-top: 1px; }

        .day-pill {
            display: inline-block; padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: 600; margin: 2px;
        }
        .day-pill.active   { background: var(--green-pale); color: var(--green-main); border: 1px solid var(--green-border); }
        .day-pill.inactive { background: #f5f5f5; color: #bbb; border: 1px solid #e0e0e0; }
        .day-pill.sunday   { background: #fff5f5; color: #e57373; border: 1px solid #ffcdd2; }
    </style>
</head>
<body>

<header class="hero">
    <!-- Office Hours Bar — clickable -->
    <div class="office-hours" id="officeHoursBar" onclick="showOfficeHoursNote()" style="cursor:pointer;" title="Click to see details">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        <span id="officeHoursText">Loading office hours...</span>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        <span id="systemStatusDot" style="width:8px;height:8px;border-radius:50%;background:#aaa;display:inline-block;margin-left:4px;"></span>
    </div>

    @auth
        @if(auth()->user()->role === 'super_admin')
            {{-- Super admin sees NOTHING on the public page --}}
            {{-- They access admin panel via 5-click logo only --}}
        @else
            {{-- Staff/Student sees their dashboard button --}}
            <div class="hero-nav">
                <a href="{{ route('student.dashboard') }}">📋 My Dashboard</a>
            </div>
        @endif
    @else
        {{-- Public sees Sign In button --}}
        <div class="hero-nav">
            <a href="{{ route('login') }}">Sign In</a>
        </div>
    @endauth

    <div class="hero-body">
        <div class="school-logo" id="secretLogo" style="cursor:default;">
            <img src="{{ asset('images/UCC_Logo.png') }}" alt="UCC Logo"
                onerror="this.style.display='none';this.parentElement.innerHTML='<span style=\'font-weight:700;font-size:18px;color:#2e7d32;\'>UCC</span>'">
        </div>
        <h1>UCC LabTech</h1>
        <p class="subtitle">Real-Time Attendance Monitoring System</p>

        <div class="clock-card">
            <div class="clock-time" id="clock">--:--:-- --</div>
            <div class="clock-date">
                <span id="dateStr">Loading...</span>
                <span class="day-badge" id="dayBadge">---</span>
            </div>
        </div>
    </div>
</header>

<!-- Office Hours Detail Modal -->
<div class="oh-modal-overlay" id="ohModal">
    <div class="oh-modal">
        <div class="oh-modal-header">
            <div class="oh-modal-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Office Hours Information
            </div>
            <button class="oh-modal-close" onclick="closeOhModal()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="oh-modal-body" id="ohModalBody">
            Loading...
        </div>
    </div>
</div>

<main class="main">

    <!-- Verify Card -->
    <div class="card">
        <div class="section-label">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
            Enter Your Student Number
        </div>

        <div class="input-row">
            <input class="student-input" id="studentInput" type="text"
                   placeholder="e.g., 20261234 - N" maxlength="20" autocomplete="off">
            <button class="verify-btn" id="verifyBtn" onclick="verifyStudent()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                Verify
            </button>
        </div>

        <p class="status-msg">
            <span class="status-dot"></span>
            <span id="statusText">Enter your student number to log attendance.</span>
        </p>

        <!-- Result Panel -->
        <div class="result-panel" id="resultPanel">
            <div id="resultContent"></div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="card">
        <div class="section-label">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.95"/></svg>
            Recent Activity
        </div>
        <ul class="activity-list" id="activityList">
            <li class="loading-row"><span class="spinner"></span> Loading recent activity...</li>
        </ul>
    </div>

</main>

<script>
// ── CLOCK ──────────────────────────────────────────────────
const DAYS   = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
const MONTHS = ['January','February','March','April','May','June','July','August','September','October','November','December'];

function updateClock() {
    const now = new Date();
    let h = now.getHours(), m = now.getMinutes(), s = now.getSeconds();
    const ampm = h >= 12 ? 'PM' : 'AM';
    h = h % 12 || 12;
    document.getElementById('clock').textContent =
        String(h).padStart(2,'0')+':'+String(m).padStart(2,'0')+':'+String(s).padStart(2,'0')+' '+ampm;
    document.getElementById('dateStr').textContent =
        DAYS[now.getDay()]+', '+MONTHS[now.getMonth()]+' '+now.getDate()+', '+now.getFullYear();
    document.getElementById('dayBadge').textContent = DAYS[now.getDay()];
}
setInterval(updateClock, 1000);
updateClock();

// ── OFFICE HOURS ────────────────────────────────────────────
let officeHoursData = null;

async function loadOfficeHours() {
    try {
        const data = await fetch('{{ route("office_hours.public") }}').then(r => r.json());
        officeHoursData = data;

        // Update bar text
        const workDayStr = data.work_day_names
            ? data.work_day_names.join(', ')
            : 'Monday - Friday';
        document.getElementById('officeHoursText').textContent =
            `Office Hours: ${workDayStr}  |  ${data.time_open_display} - ${data.time_close_display}`;

        // Status dot color
        const dot = document.getElementById('systemStatusDot');
        if (data.is_sunday) {
            dot.style.background = '#bbb';
        } else if (data.is_manually_open) {
            dot.style.background = '#42a5f5';
        } else if (data.is_manually_closed) {
            dot.style.background = '#fb8c00';
        } else {
            dot.style.background = data.is_open ? '#69f0ae' : '#ef9a9a';
        }

        // Update status text below input
        updateStatusText(data);

    } catch(e) {
        document.getElementById('officeHoursText').textContent = 'Office Hours: Monday - Friday  |  8:00 AM - 5:00 PM';
    }
}

function updateStatusText(data) {
    const el = document.getElementById('statusText');
    if (!el) return;
    if (data.is_sunday) {
        el.textContent = 'System is closed today (Sunday). Please come back on Monday.';
    } else if (data.is_manually_closed) {
        el.textContent = 'Attendance is currently closed by the Administrator.';
    } else if (data.is_manually_open) {
        el.textContent = 'Attendance is currently open (manually opened by Admin).';
    } else if (data.is_open) {
        el.textContent = 'System is open. Enter your student number to log attendance.';
    } else {
        const days = data.work_day_names ?? ['Monday'];
        el.textContent = `System is closed. Office hours: ${days[0]}–${days[days.length-1]}, ${data.time_open_display}–${data.time_close_display}`;
    }
}

function showOfficeHoursNote() {
    const data = officeHoursData;
    const modal = document.getElementById('ohModal');
    const body  = document.getElementById('ohModalBody');

    if (!data) { modal.classList.add('open'); body.innerHTML = 'Loading...'; loadOfficeHours().then(() => showOfficeHoursNote()); return; }

    const allDays = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    const dayPills = allDays.map((d, i) => {
        const cls = i === 0 ? 'sunday' : (data.work_days.includes(i) ? 'active' : 'inactive');
        return `<span class="day-pill ${cls}">${d}</span>`;
    }).join('');

    let statusHtml = '';
    if (data.is_sunday) {
        statusHtml = `<span class="oh-status-closed">Closed — Sunday</span>`;
    } else if (data.is_manually_open) {
        statusHtml = `<span class="oh-status-manual-open">🔵 Manually Opened</span>`;
    } else if (data.is_manually_closed) {
        statusHtml = `<span class="oh-status-manual-closed">🟠 Manually Closed</span>`;
    } else {
        statusHtml = data.is_open
            ? `<span class="oh-status-open">🟢 Open</span>`
            : `<span class="oh-status-closed">🔴 Closed</span>`;
    }

    const noteHtml = data.note ? `
        <div class="oh-note">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span><strong>Notice:</strong> ${data.note}</span>
        </div>` : '';

    const updatedAt = data.updated_at ? new Date(data.updated_at).toLocaleString('en-PH', { month:'short', day:'numeric', year:'numeric', hour:'numeric', minute:'2-digit', hour12:true }) : '—';

    body.innerHTML = `
        <div class="oh-row">
            <span class="lbl">Status</span>
            <span class="val">${statusHtml}</span>
        </div>
        <div class="oh-row">
            <span class="lbl">Work Days</span>
            <span class="val">${dayPills}</span>
        </div>
        <div class="oh-row">
            <span class="lbl">Hours</span>
            <span class="val">${data.time_open_display} – ${data.time_close_display}</span>
        </div>
        <div class="oh-row">
            <span class="lbl">Sunday</span>
            <span class="val" style="color:#e57373;font-weight:600;">Always closed — no exceptions</span>
        </div>
        <div class="oh-row">
            <span class="lbl">Last Updated</span>
            <span class="val">${updatedAt} ${data.updated_by ? 'by <strong>'+data.updated_by+'</strong>' : ''}</span>
        </div>
        ${noteHtml}
    `;

    modal.classList.add('open');
}

function closeOhModal() {
    document.getElementById('ohModal').classList.remove('open');
}
document.getElementById('ohModal').addEventListener('click', function(e) {
    if (e.target === this) closeOhModal();
});

// Reload office hours every 5 minutes
loadOfficeHours();
setInterval(loadOfficeHours, 5 * 60 * 1000);

// ── VERIFY ─────────────────────────────────────────────────
async function verifyStudent() {
    const input   = document.getElementById('studentInput');
    const panel   = document.getElementById('resultPanel');
    const content = document.getElementById('resultContent');
    const btn     = document.getElementById('verifyBtn');
    const val     = input.value.trim();

    if (!val) { input.focus(); return; }

    btn.disabled = true;
    btn.innerHTML = `<span class="spinner" style="border-color:rgba(255,255,255,.4);border-top-color:#fff;"></span> Checking...`;
    panel.className = 'result-panel';

    try {
        const res  = await fetch('{{ route("attendance.verify") }}', {
            method : 'POST',
            headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':'{{ csrf_token() }}', 'Accept':'application/json' },
            body   : JSON.stringify({ student_number: val }),
        });
        const data = await res.json();

        switch(data.status) {
            case 'time_in':
                panel.className = 'result-panel time-in show';
                content.innerHTML = `
                    <div class="result-icon">✅</div>
                    <div class="result-title">Time In Recorded!</div>
                    <div class="result-name">${data.student.name}</div>
                    <div class="result-meta">${data.student.course ?? ''} ${data.student.campus ? '· '+data.student.campus : ''} ${data.student.year_level ? '· '+data.student.year_level : ''}</div>
                    <div class="timelog-row">
                        <div class="timelog-item"><span class="timelog-label">Time In</span><span class="timelog-value in">${data.time}</span></div>
                    </div>`;
                loadActivity();
                break;

            case 'time_out':
                panel.className = 'result-panel time-out show';
                content.innerHTML = `
                    <div class="result-icon">👋</div>
                    <div class="result-title">Time Out Recorded!</div>
                    <div class="result-name">${data.student.name}</div>
                    <div class="result-meta">${data.student.course ?? ''} ${data.student.campus ? '· '+data.student.campus : ''}</div>
                    <div class="timelog-row">
                        <div class="timelog-item"><span class="timelog-label">Time In</span><span class="timelog-value in">${data.time_in}</span></div>
                        <div class="timelog-item"><span class="timelog-label">Time Out</span><span class="timelog-value out">${data.time_out}</span></div>
                    </div>`;
                loadActivity();
                break;

            case 'already_done':
                panel.className = 'result-panel already show';
                content.innerHTML = `
                    <div class="result-icon">ℹ️</div>
                    <div class="result-title">Already Completed Today</div>
                    <div class="result-name">${data.student.name}</div>
                    <div class="result-msg" style="color:var(--text-mid);">${data.message}</div>
                    <div class="timelog-row">
                        <div class="timelog-item"><span class="timelog-label">Time In</span><span class="timelog-value in">${data.time_in}</span></div>
                        <div class="timelog-item"><span class="timelog-label">Time Out</span><span class="timelog-value out">${data.time_out}</span></div>
                    </div>`;
                break;

            case 'closed':
                panel.className = 'result-panel pending show';
                content.innerHTML = `
                    <div class="result-icon">🔒</div>
                    <div class="result-title">Attendance System Closed</div>
                    <div class="pending-note">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <span>${data.message}</span>
                    </div>`;
                break;

            case 'pending':
                panel.className = 'result-panel pending show';
                content.innerHTML = `
                    <div class="result-icon">⏳</div>
                    <div class="result-title">Account Pending Approval</div>
                    ${data.name ? `<div class="result-name">${data.name}</div>` : ''}
                    <div class="pending-note">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <span>${data.message}</span>
                    </div>`;
                break;

            case 'rejected':
                panel.className = 'result-panel rejected show';
                content.innerHTML = `
                    <div class="result-icon">🚫</div>
                    <div class="result-title">Registration Rejected</div>
                    ${data.name ? `<div class="result-name">${data.name}</div>` : ''}
                    <div class="rejected-note">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                        <span>${data.message}</span>
                    </div>`;
                break;

            case 'deactivated':
                panel.className = 'result-panel rejected show';
                content.innerHTML = `
                    <div class="result-icon">🔒</div>
                    <div class="result-title">Account Deactivated</div>
                    ${data.name ? `<div class="result-name">${data.name}</div>` : ''}
                    <div class="rejected-note">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        <span>${data.message}</span>
                    </div>`;
                break;

            default:
                panel.className = 'result-panel not-found show';
                content.innerHTML = `
                    <div class="result-icon">❌</div>
                    <div class="result-title">Student Number Not Found</div>
                    <div class="result-msg" style="color:var(--text-mid);">The student number <strong>${val}</strong> is not registered in the system.</div>
                    <div class="register-hint">Not registered yet? <a href="/auth/register?student_number=${encodeURIComponent(val)}" class="register-link">Create an account →</a></div>`;
                break;
        }
    } catch(e) {
        panel.className = 'result-panel not-found show';
        content.innerHTML = `<div class="result-title">❌ Network Error</div><div class="result-msg">Please check your connection and try again.</div>`;
    }

    btn.disabled = false;
    btn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="15" height="15"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg> Verify`;
}

document.getElementById('studentInput').addEventListener('keydown', e => { if (e.key === 'Enter') verifyStudent(); });

// ── SECRET 5-CLICK ON LOGO ─────────────────────────────────
(function() {
    const logo     = document.getElementById('secretLogo');
    let clickCount = 0;
    let timer      = null;

    logo.addEventListener('click', function() {
        clickCount++;

        clearTimeout(timer);
        timer = setTimeout(() => { clickCount = 0; }, 3000);

        if (clickCount === 5) {
            clickCount = 0;
            clearTimeout(timer);

            @auth
                @if(auth()->user()->role === 'super_admin')
                    // Already logged in as super admin → go directly to admin panel
                    window.location.href = '{{ route("admin.index") }}';
                @else
                    // Staff → go to their dashboard
                    window.location.href = '{{ route("student.dashboard") }}';
                @endif
            @else
                // Not logged in → go to hidden admin login
                window.location.href = '{{ route("admin.login") }}';
            @endauth
        }
    });
})();

// ── RECENT ACTIVITY ────────────────────────────────────────
function initials(name) { return (name||'?').split(' ').slice(0,2).map(w=>w[0]).join('').toUpperCase(); }

async function loadActivity() {
    const list = document.getElementById('activityList');
    list.innerHTML = '<li class="loading-row"><span class="spinner"></span> Loading...</li>';
    try {
        const data = await fetch('{{ route("attendance.recent") }}').then(r => r.json());
        if (!data.length) {
            list.innerHTML = `<li class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                No activity recorded yet today.</li>`;
            return;
        }
        list.innerHTML = data.map(item => `
            <li class="activity-item">
                <div class="avatar">${initials(item.name)}</div>
                <div class="activity-info">
                    <div class="activity-name">${item.name}</div>
                    <div class="activity-detail">${item.student_number} ${item.course ? '· '+item.course : ''} ${item.campus ? '· '+item.campus : ''}</div>
                </div>
                <div class="time-chips">
                    ${item.time_in  ? `<span class="time-chip in">IN ${item.time_in}</span>` : ''}
                    ${item.time_out ? `<span class="time-chip out">OUT ${item.time_out}</span>` : `<span class="time-chip pending-chip">No time-out yet</span>`}
                </div>
            </li>`).join('');
    } catch(e) {
        list.innerHTML = '<li class="empty-state"><div>Failed to load activity.</div></li>';
    }
}

loadActivity();
setInterval(loadActivity, 30000);
</script>
</body>
</html>