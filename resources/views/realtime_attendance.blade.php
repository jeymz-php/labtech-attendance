<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Attendance - UCC LabTech</title>
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
            --text-dark:    #1b1b1b;
            --text-mid:     #4a4a4a;
            --text-muted:   #888;
            --white:        #ffffff;
            --bg-page:      #f5f5f5;
            --radius:       14px;
            --shadow:       0 4px 24px rgba(0,0,0,.10);
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg-page);
            min-height: 100vh;
            color: var(--text-dark);
        }

        /* ── HEADER HERO ─────────────────────────────────── */
        .hero {
            background: linear-gradient(160deg, var(--green-dark) 0%, var(--green-main) 100%);
            color: var(--white);
            padding: 0 0 48px;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        .office-hours {
            background: rgba(0,0,0,.18);
            text-align: center;
            padding: 10px 16px;
            font-size: 13px;
            letter-spacing: .4px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .office-hours svg { width: 14px; height: 14px; opacity: .8; }

        .hero-body {
            text-align: center;
            padding: 36px 24px 0;
            position: relative;
        }

        .school-logo {
            width: 80px;
            height: 80px;
            background: var(--white);
            border-radius: 18px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 24px rgba(0,0,0,.2);
            overflow: hidden;
        }
        .school-logo img {
            width: 64px;
            height: 64px;
            object-fit: contain;
        }
        .school-logo .logo-placeholder {
            font-size: 28px;
            font-weight: 700;
            color: var(--green-main);
            letter-spacing: -1px;
        }

        .hero h1 {
            font-size: clamp(26px, 5vw, 36px);
            font-weight: 600;
            letter-spacing: -.5px;
            margin-bottom: 6px;
        }
        .hero .subtitle {
            font-size: 14px;
            opacity: .75;
            font-weight: 400;
            letter-spacing: .3px;
        }

        /* ── CLOCK ───────────────────────────────────────── */
        .clock-card {
            background: rgba(255,255,255,.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,.18);
            border-radius: 50px;
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            padding: 18px 40px 14px;
            margin-top: 28px;
        }
        .clock-time {
            font-family: 'DM Mono', monospace;
            font-size: clamp(30px, 6vw, 44px);
            font-weight: 500;
            letter-spacing: 2px;
            line-height: 1;
        }
        .clock-date {
            margin-top: 8px;
            font-size: 13px;
            opacity: .8;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .day-badge {
            background: var(--red-badge);
            color: var(--white);
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            letter-spacing: .5px;
            text-transform: uppercase;
        }

        /* ── MAIN CONTENT ────────────────────────────────── */
        .main {
            max-width: 680px;
            margin: -28px auto 0;
            padding: 0 16px 60px;
            position: relative;
            z-index: 10;
        }

        /* ── VERIFY CARD ─────────────────────────────────── */
        .card {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 28px 24px;
            margin-bottom: 20px;
        }

        .section-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--green-main);
            letter-spacing: .5px;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }
        .section-label svg { width: 16px; height: 16px; }

        .input-row {
            display: flex;
            gap: 10px;
        }
        .student-input {
            flex: 1;
            border: 1.5px solid var(--green-border);
            border-radius: 10px;
            padding: 13px 16px;
            font-family: inherit;
            font-size: 15px;
            color: var(--text-dark);
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            background: #fafafa;
        }
        .student-input::placeholder { color: #bbb; }
        .student-input:focus {
            border-color: var(--green-main);
            box-shadow: 0 0 0 3px rgba(46,125,50,.12);
            background: var(--white);
        }
        .verify-btn {
            background: var(--green-main);
            color: var(--white);
            border: none;
            border-radius: 10px;
            padding: 13px 22px;
            font-family: inherit;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background .2s, transform .1s;
            white-space: nowrap;
        }
        .verify-btn:hover { background: var(--green-mid); }
        .verify-btn:active { transform: scale(.97); }
        .verify-btn svg { width: 16px; height: 16px; }

        .status-msg {
            margin-top: 12px;
            font-size: 13px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--green-light);
            display: inline-block;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: .4; transform: scale(.85); }
        }

        /* ── RESULT PANEL ────────────────────────────────── */
        .result-panel {
            display: none;
            margin-top: 16px;
            border-radius: 10px;
            padding: 16px;
            border: 1.5px solid transparent;
        }
        .result-panel.success {
            display: block;
            background: #f1faf2;
            border-color: var(--green-border);
        }
        .result-panel.error {
            display: block;
            background: #fff5f5;
            border-color: #ffcdd2;
        }
        .result-name { font-weight: 600; font-size: 16px; margin-bottom: 4px; }
        .result-meta { font-size: 13px; color: var(--text-mid); }
        .result-time { font-size: 12px; color: var(--text-muted); margin-top: 6px; }
        .result-error-msg { color: #c62828; font-size: 14px; font-weight: 500; }

        /* ── RECENT ACTIVITY ─────────────────────────────── */
        .activity-list { list-style: none; }
        .activity-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .activity-item:last-child { border-bottom: none; padding-bottom: 0; }
        .activity-item:first-child { padding-top: 0; }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--green-pale);
            color: var(--green-main);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
        }
        .activity-info { flex: 1; min-width: 0; }
        .activity-name {
            font-weight: 600;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .activity-detail { font-size: 12px; color: var(--text-muted); margin-top: 2px; }
        .activity-time {
            font-size: 12px;
            color: var(--text-muted);
            white-space: nowrap;
            font-family: 'DM Mono', monospace;
        }

        .loading-row {
            text-align: center;
            padding: 24px 0;
            color: var(--text-muted);
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .spinner {
            width: 16px;
            height: 16px;
            border: 2px solid var(--green-border);
            border-top-color: var(--green-main);
            border-radius: 50%;
            animation: spin .8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        .empty-state {
            text-align: center;
            padding: 28px 0 12px;
            color: var(--text-muted);
            font-size: 13px;
        }
        .empty-state svg {
            width: 36px; height: 36px;
            margin-bottom: 8px;
            opacity: .3;
        }

        .result-register-hint {
            margin-top: 10px;
            font-size: 13px;
            color: var(--text-mid);
        }
        .register-link {
            color: var(--green-main);
            font-weight: 600;
            text-decoration: none;
            border-bottom: 1.5px solid var(--green-border);
            padding-bottom: 1px;
            transition: color .2s;
        }
        .register-link:hover { color: var(--green-mid); }
            </style>
</head>
<body>

<!-- ══ HERO ══════════════════════════════════════════════ -->
<header class="hero">
    <div class="office-hours">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Office Hours: Monday - Friday &nbsp;|&nbsp; 8:00 AM - 5:00 PM
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </div>

    <div class="hero-body">
        <div class="school-logo">
            {{-- Replace with: <img src="{{ asset('images/ucc-logo.png') }}" alt="UCC Logo"> --}}
            <span class="logo-placeholder">UCC</span>
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

<!-- ══ MAIN ═══════════════════════════════════════════════ -->
<main class="main">

    <!-- Verify Card -->
    <div class="card">
        <div class="section-label">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                <rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/>
            </svg>
            Enter Your Student Number
        </div>

        <div class="input-row">
            <input
                class="student-input"
                id="studentInput"
                type="text"
                placeholder="e.g., 20261234 - S"
                maxlength="20"
                autocomplete="off"
            >
            <button class="verify-btn" id="verifyBtn" onclick="verifyStudent()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                Verify
            </button>
        </div>

        <p class="status-msg">
            <span class="status-dot"></span>
            <span id="statusText">System is closed today. Please come back on Monday.</span>
        </p>

        <!-- Result -->
        <div class="result-panel" id="resultPanel">
            <div id="resultContent"></div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="card">
        <div class="section-label">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                <polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.95"/>
            </svg>
            Recent Activity
        </div>

        <ul class="activity-list" id="activityList">
            <li class="loading-row">
                <span class="spinner"></span>
                Loading recent activity...
            </li>
        </ul>
    </div>

</main>

<script>
// ── CLOCK ──────────────────────────────────────────────────
function updateClock() {
    const now   = new Date();
    const days  = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    const months= ['January','February','March','April','May','June',
                   'July','August','September','October','November','December'];

    let h = now.getHours(), m = now.getMinutes(), s = now.getSeconds();
    const ampm = h >= 12 ? 'PM' : 'AM';
    h = h % 12 || 12;

    document.getElementById('clock').textContent =
        String(h).padStart(2,'0') + ':' +
        String(m).padStart(2,'0') + ':' +
        String(s).padStart(2,'0') + ' ' + ampm;

    document.getElementById('dateStr').textContent =
        days[now.getDay()] + ', ' + months[now.getMonth()] + ' ' + now.getDate() + ', ' + now.getFullYear();

    document.getElementById('dayBadge').textContent = days[now.getDay()];
}
setInterval(updateClock, 1000);
updateClock();

// ── SYSTEM STATUS ──────────────────────────────────────────
function getSystemStatus() {
    const now  = new Date();
    const day  = now.getDay();   // 0=Sun, 6=Sat
    const hour = now.getHours();
    const isWeekday = day >= 1 && day <= 5;
    const isOpen    = isWeekday && hour >= 8 && hour < 17;
    const days      = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

    let msg = '';
    if (isOpen) {
        msg = 'System is open. Enter your student number to log attendance.';
    } else if (!isWeekday) {
        // find next Monday
        const next = new Date(now);
        next.setDate(now.getDate() + ((8 - day) % 7 || 7));
        msg = 'System is closed today. Please come back on Monday.';
    } else if (hour < 8) {
        msg = 'System opens at 8:00 AM today.';
    } else {
        msg = 'System is closed for today. See you tomorrow!';
    }

    document.getElementById('statusText').textContent = msg;
    return isOpen;
}
getSystemStatus();

// ── VERIFY ─────────────────────────────────────────────────
async function verifyStudent() {
    const input  = document.getElementById('studentInput');
    const panel  = document.getElementById('resultPanel');
    const content= document.getElementById('resultContent');
    const btn    = document.getElementById('verifyBtn');
    const val    = input.value.trim();

    if (!val) {
        input.focus();
        return;
    }

    btn.disabled = true;
    btn.textContent = 'Checking...';
    panel.className = 'result-panel';

    try {
        const res  = await fetch('{{ route("attendance.verify") }}', {
            method : 'POST',
            headers: {
                'Content-Type'     : 'application/json',
                'X-CSRF-TOKEN'     : '{{ csrf_token() }}',
                'Accept'           : 'application/json',
            },
            body: JSON.stringify({ student_number: val }),
        });
        const data = await res.json();

        if (data.success) {
            panel.className = 'result-panel success';
            content.innerHTML = `
                <div class="result-name">✅ ${data.student.name}</div>
                <div class="result-meta">${data.student.course ?? ''} &bull; ${data.student.year_level ?? ''}</div>
                <div class="result-time">Logged at ${data.logged_at}</div>
            `;
            loadActivity();
        } else {
            panel.className = 'result-panel error';
            content.innerHTML = `
                <div class="result-error-msg">❌ ${data.message ?? 'Student not found.'}</div>
                <div class="result-register-hint">
                    Not registered yet?
                    <a href="/auth/register?student_number=${encodeURIComponent(val)}" class="register-link">
                        Create an account →
                    </a>
                </div>
            `;
        }
    } catch (e) {
        panel.className = 'result-panel error';
        content.innerHTML = `<div class="result-error-msg">❌ Network error. Please try again.</div>`;
    }

    btn.disabled = false;
    btn.innerHTML = `
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg> Verify`;
}

// Enter key triggers verify
document.getElementById('studentInput').addEventListener('keydown', e => {
    if (e.key === 'Enter') verifyStudent();
});

// ── RECENT ACTIVITY ────────────────────────────────────────
function initials(name) {
    return (name ?? '?').split(' ').slice(0,2).map(w => w[0]).join('').toUpperCase();
}

async function loadActivity() {
    const list = document.getElementById('activityList');
    list.innerHTML = '<li class="loading-row"><span class="spinner"></span> Loading recent activity...</li>';

    try {
        const res  = await fetch('{{ route("attendance.recent") }}', {
            headers: { 'Accept': 'application/json' }
        });
        const data = await res.json();

        if (!data.length) {
            list.innerHTML = `
                <li class="empty-state">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <div>No activity recorded yet today.</div>
                </li>`;
            return;
        }

        list.innerHTML = data.map(item => `
            <li class="activity-item">
                <div class="avatar">${initials(item.name)}</div>
                <div class="activity-info">
                    <div class="activity-name">${item.name}</div>
                    <div class="activity-detail">${item.student_number} &bull; ${item.course ?? 'N/A'}</div>
                </div>
                <div class="activity-time">${item.time_in}</div>
            </li>
        `).join('');

    } catch (e) {
        list.innerHTML = '<li class="empty-state"><div>Failed to load activity.</div></li>';
    }
}

loadActivity();
// Auto-refresh every 30 seconds
setInterval(loadActivity, 30000);
</script>
</body>
</html>