<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Access — UCC LabTech</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/UCC_Logo.ico') }}">
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
            --text-dark:   #1b1b1b;
            --text-muted:  #888;
            --white:       #ffffff;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            background: #0f1f14;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            position: relative;
            overflow: hidden;
        }

        /* Dark grid background */
        body::before {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(46,125,50,.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(46,125,50,.08) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }

        /* Glow effect */
        body::after {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(46,125,50,.15) 0%, transparent 70%);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        .login-wrap {
            width: 100%;
            max-width: 400px;
            position: relative;
            z-index: 10;
        }

        /* Shield icon top */
        .admin-icon {
            text-align: center;
            margin-bottom: 24px;
        }
        .shield-wrap {
            width: 72px; height: 72px;
            background: rgba(46,125,50,.15);
            border: 1.5px solid rgba(46,125,50,.3);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
        }
        .shield-wrap svg { width: 34px; height: 34px; color: #4caf50; }
        .admin-icon h1 { font-size: 20px; font-weight: 700; color: var(--white); letter-spacing: -.3px; }
        .admin-icon p  { font-size: 12px; color: rgba(255,255,255,.4); margin-top: 4px; letter-spacing: .3px; }

        /* Card */
        .card {
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 16px;
            padding: 28px 26px;
            backdrop-filter: blur(12px);
        }

        .alert {
            padding: 11px 14px; border-radius: 8px;
            font-size: 13px; margin-bottom: 16px; display: none;
        }
        .alert.error   { background: rgba(229,57,53,.15); border: 1px solid rgba(229,57,53,.3); color: #ef9a9a; display: block; }
        .alert.success { background: rgba(46,125,50,.15); border: 1px solid rgba(46,125,50,.3); color: #a5d6a7; display: block; }

        .form-group { margin-bottom: 16px; }
        .form-label {
            font-size: 11px; font-weight: 700;
            color: rgba(255,255,255,.5);
            text-transform: uppercase; letter-spacing: .6px;
            display: flex; align-items: center; gap: 6px;
            margin-bottom: 7px;
        }
        .form-label svg { width: 13px; height: 13px; }

        .input-wrap { position: relative; }
        .form-input {
            width: 100%;
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 9px;
            padding: 12px 42px 12px 14px;
            font-family: inherit; font-size: 14px;
            color: var(--white); outline: none;
            transition: border-color .2s, background .2s;
        }
        .form-input::placeholder { color: rgba(255,255,255,.2); }
        .form-input:focus {
            border-color: rgba(46,125,50,.6);
            background: rgba(255,255,255,.09);
            box-shadow: 0 0 0 3px rgba(46,125,50,.1);
        }

        .pw-toggle {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: rgba(255,255,255,.3); padding: 4px;
            display: flex; align-items: center;
        }
        .pw-toggle:hover { color: rgba(255,255,255,.6); }
        .pw-toggle svg { width: 15px; height: 15px; }

        .login-btn {
            width: 100%;
            background: var(--green-main);
            color: var(--white);
            border: none; border-radius: 9px;
            padding: 13px;
            font-family: inherit; font-size: 14px; font-weight: 700;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: background .2s, transform .1s;
            margin-top: 4px;
        }
        .login-btn:hover   { background: var(--green-mid); }
        .login-btn:active  { transform: scale(.98); }
        .login-btn:disabled { opacity: .5; cursor: not-allowed; }
        .login-btn svg { width: 16px; height: 16px; }

        .spinner {
            width: 16px; height: 16px;
            border: 2px solid rgba(255,255,255,.3);
            border-top-color: var(--white);
            border-radius: 50%;
            animation: spin .7s linear infinite;
            display: none;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            font-size: 12px;
            color: rgba(255,255,255,.25);
            text-decoration: none;
            transition: color .2s;
        }
        .back-link a:hover { color: rgba(255,255,255,.5); }

        /* Security badge */
        .security-note {
            text-align: center;
            margin-top: 18px;
            font-size: 11px;
            color: rgba(255,255,255,.2);
            display: flex; align-items: center; justify-content: center; gap: 5px;
        }
        .security-note svg { width: 11px; height: 11px; }
    </style>
</head>
<body>

<div class="login-wrap">

    <div class="admin-icon">
        <div class="shield-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
        </div>
        <h1>Administrator Access</h1>
        <p>UCC LabTech — Restricted Portal</p>
    </div>

    <div class="card">
        <div class="alert" id="alert"></div>

        <div class="form-group">
            <div class="form-label">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                Admin Email
            </div>
            <div class="input-wrap">
                <input class="form-input" id="email" type="email"
                       placeholder="Email Address" autocomplete="email">
            </div>
        </div>

        <div class="form-group">
            <div class="form-label">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                Password
            </div>
            <div class="input-wrap">
                <input class="form-input" id="password" type="password"
                       placeholder="Password" autocomplete="current-password">
                <button class="pw-toggle" type="button" onclick="togglePw()">
                    <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>
        </div>

        <button class="login-btn" id="loginBtn" onclick="doLogin()">
            <span id="btnText">Access Admin Panel</span>
            <svg id="btnIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
            <div class="spinner" id="spinner"></div>
        </button>
    </div>

    <div class="back-link">
        <a href="{{ route('home') }}">← Back to Attendance Page</a>
    </div>

    <div class="security-note">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
        Restricted access — authorized personnel only
    </div>

</div>

<script>
function togglePw() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('eyeIcon');
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    icon.innerHTML = isHidden
        ? `<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>`
        : `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
}

document.addEventListener('keydown', e => { if (e.key === 'Enter') doLogin(); });

async function doLogin() {
    const email    = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const btn      = document.getElementById('loginBtn');
    const spinner  = document.getElementById('spinner');
    const btnIcon  = document.getElementById('btnIcon');
    const btnText  = document.getElementById('btnText');

    clearAlert();
    if (!email)    { showAlert('Please enter your email address.'); return; }
    if (!password) { showAlert('Please enter your password.'); return; }

    btn.disabled          = true;
    spinner.style.display = 'block';
    btnIcon.style.display = 'none';
    btnText.textContent   = 'Authenticating...';

    try {
        const res  = await fetch('{{ route("admin.login.post") }}', {
            method : 'POST',
            headers: {
                'Content-Type' : 'application/json',
                'Accept'       : 'application/json',
                'X-CSRF-TOKEN' : '{{ csrf_token() }}',
            },
            body: JSON.stringify({ email, password }),
        });
        const data = await res.json();

        if (data.success) {
            showAlert('Access granted. Redirecting...', 'success');
            setTimeout(() => window.location.href = data.redirect, 800);
        } else {
            showAlert(data.message ?? 'Access denied.');
        }
    } catch(e) {
        showAlert('Network error. Please try again.');
    }

    btn.disabled          = false;
    spinner.style.display = 'none';
    btnIcon.style.display = 'block';
    btnText.textContent   = 'Access Admin Panel';
}

function showAlert(msg, type = 'error') {
    const el = document.getElementById('alert');
    el.textContent = msg;
    el.className   = 'alert ' + type;
}
function clearAlert() {
    document.getElementById('alert').className = 'alert';
}
</script>
</body>
</html>