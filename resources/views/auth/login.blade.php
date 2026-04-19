<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UCC LabTech Attendance</title>
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
            --red:         #e53935;
            --text-dark:   #1b1b1b;
            --text-mid:    #4a4a4a;
            --text-muted:  #888;
            --white:       #ffffff;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #c8e6c9 0%, #a5d6a7 50%, #81c784 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        .container {
            width: 100%;
            max-width: 900px;
            background: var(--white);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0,0,0,.12);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 520px;
        }

        /* ── LEFT PANEL ── */
        .left-panel {
            background: linear-gradient(160deg, var(--green-dark) 0%, var(--green-main) 100%);
            color: var(--white);
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        .school-logo {
            width: 72px; height: 72px;
            background: var(--white);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 28px;
            box-shadow: 0 4px 16px rgba(0,0,0,.2);
            font-size: 20px; font-weight: 700;
            color: var(--green-main);
            flex-shrink: 0;
            position: relative; z-index: 1;
        }

        .left-panel h2 {
            font-size: 28px; font-weight: 700;
            margin-bottom: 10px; line-height: 1.2;
            position: relative; z-index: 1;
        }
        .left-panel p {
            font-size: 14px; opacity: .75;
            margin-bottom: 32px;
            position: relative; z-index: 1;
        }

        .features { list-style: none; display: flex; flex-direction: column; gap: 14px; position: relative; z-index: 1; }
        .features li {
            display: flex; align-items: center; gap: 12px;
            font-size: 14px; opacity: .9;
        }
        .check-icon {
            width: 22px; height: 22px; border-radius: 50%;
            background: rgba(255,255,255,.2);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .check-icon svg { width: 12px; height: 12px; }

        /* ── RIGHT PANEL ── */
        .right-panel {
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-panel h1 { font-size: 26px; font-weight: 700; margin-bottom: 4px; }
        .right-panel .sub { font-size: 13px; color: var(--text-muted); margin-bottom: 32px; }

        .alert {
            padding: 12px 14px; border-radius: 8px;
            font-size: 13px; margin-bottom: 16px; display: none;
        }
        .alert.error   { background: #fff5f5; border: 1px solid #ffcdd2; color: #c62828; display: block; }
        .alert.success { background: var(--green-pale); border: 1px solid var(--green-border); color: var(--green-dark); display: block; }

        .form-group { margin-bottom: 18px; }
        .form-label {
            font-size: 12px; font-weight: 600; color: var(--text-mid);
            display: flex; align-items: center; gap: 6px; margin-bottom: 7px;
        }
        .form-label svg { width: 14px; height: 14px; color: var(--green-main); }

        .input-wrap { position: relative; }
        .form-input {
            width: 100%;
            border: 1.5px solid #e0e0e0;
            border-radius: 10px;
            padding: 12px 44px 12px 14px;
            font-family: inherit; font-size: 14px; color: var(--text-dark);
            outline: none; background: #fafafa;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-input:focus {
            border-color: var(--green-main);
            box-shadow: 0 0 0 3px rgba(46,125,50,.1);
            background: var(--white);
        }
        .form-input::placeholder { color: #bbb; }
        .form-input.error { border-color: var(--red); }

        .pw-toggle {
            position: absolute; right: 13px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer; color: var(--text-muted);
            padding: 4px; display: flex; align-items: center;
        }
        .pw-toggle:hover { color: var(--green-main); }
        .pw-toggle svg { width: 16px; height: 16px; }

        .forgot-row {
            text-align: right; margin-top: -10px; margin-bottom: 20px;
        }
        .forgot-link {
            font-size: 12px; color: var(--green-main); font-weight: 600;
            text-decoration: none;
        }
        .forgot-link:hover { text-decoration: underline; }

        .login-btn {
            width: 100%;
            background: var(--green-main); color: var(--white);
            border: none; border-radius: 10px;
            padding: 13px; font-family: inherit;
            font-size: 15px; font-weight: 600;
            cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: background .2s, transform .1s;
        }
        .login-btn:hover   { background: var(--green-mid); }
        .login-btn:active  { transform: scale(.98); }
        .login-btn:disabled { opacity: .6; cursor: not-allowed; }
        .login-btn svg { width: 16px; height: 16px; }

        .divider { border: none; border-top: 1px dashed #e0e0e0; margin: 24px 0; }

        .register-row { text-align: center; }
        .register-row p { font-size: 13px; color: var(--text-muted); margin-bottom: 10px; }
        .register-btn {
            display: inline-flex; align-items: center; gap: 8px;
            border: 1.5px solid var(--green-border);
            background: var(--white); color: var(--green-main);
            border-radius: 8px; padding: 10px 20px;
            font-family: inherit; font-size: 13px; font-weight: 600;
            text-decoration: none; transition: background .2s;
        }
        .register-btn:hover { background: var(--green-pale); }
        .register-btn svg { width: 15px; height: 15px; }

        .spinner {
            width: 16px; height: 16px;
            border: 2px solid rgba(255,255,255,.4);
            border-top-color: var(--white);
            border-radius: 50%;
            animation: spin .7s linear infinite;
            display: none;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        .page-footer {
            text-align: center; margin-top: 20px;
            font-size: 12px; color: rgba(255,255,255,.7);
        }

        @media (max-width: 640px) {
            .container { grid-template-columns: 1fr; }
            .left-panel { display: none; }
            .right-panel { padding: 36px 24px; }
        }
    </style>
</head>
<body>

<div style="width:100%;max-width:900px;">
    <div class="container">

        <!-- LEFT PANEL -->
        <div class="left-panel">
            <div class="school-logo">UCC</div>
            <h2>UCC LabTech</h2>
            <p>Real-Time Attendance Monitoring System</p>
            <ul class="features">
                <li>
                    <div class="check-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    Easy time-in/time-out tracking
                </li>
                <li>
                    <div class="check-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    View your attendance history
                </li>
                <li>
                    <div class="check-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    Get notified of late entries
                </li>
                <li>
                    <div class="check-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    Access from any device
                </li>
            </ul>
        </div>

        <!-- RIGHT PANEL -->
        <div class="right-panel">
            <h1>Welcome Back</h1>
            <p class="sub">Sign in to your UCC LabTech account</p>

            <div class="alert" id="alert"></div>

            <!-- Email -->
            <div class="form-group">
                <div class="form-label">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    Email Address
                </div>
                <div class="input-wrap">
                    <input class="form-input" id="email" type="email" placeholder="name@example.com" autocomplete="email">
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <div class="form-label">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    Password
                </div>
                <div class="input-wrap">
                    <input class="form-input" id="password" type="password" placeholder="Enter your password" autocomplete="current-password">
                    <button class="pw-toggle" type="button" onclick="togglePw()" tabindex="-1">
                        <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <div class="forgot-row">
                <a href="#" class="forgot-link">Forgot password?</a>
            </div>

            <button class="login-btn" id="loginBtn" onclick="doLogin()">
                <span id="btnText">Sign In</span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" id="btnIcon" width="16" height="16"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                <div class="spinner" id="spinner"></div>
            </button>

            <hr class="divider">

            <div class="register-row">
                <p>Don't have an account yet?</p>
                <a href="{{ route('register') }}" class="register-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                    Create an Account
                </a>
            </div>
        </div>

    </div>
    <div class="page-footer">© {{ date('Y') }} UCC LabTech Attendance System</div>
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

// Enter key
document.addEventListener('keydown', e => {
    if (e.key === 'Enter') doLogin();
});

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

    btn.disabled      = true;
    spinner.style.display = 'block';
    btnIcon.style.display = 'none';
    btnText.textContent   = 'Signing in...';

    try {
        const res  = await fetch('{{ route("login.post") }}', {
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
            showAlert('Login successful! Redirecting...', 'success');
            setTimeout(() => window.location.href = data.redirect ?? '/', 800);
        } else {
            showAlert(data.message ?? 'Login failed. Please try again.');
        }
    } catch (e) {
        showAlert('Network error. Please try again.');
    }

    btn.disabled          = false;
    spinner.style.display = 'none';
    btnIcon.style.display = 'block';
    btnText.textContent   = 'Sign In';
}

function showAlert(msg, type = 'error') {
    const el = document.getElementById('alert');
    el.textContent = msg;
    el.className = 'alert ' + type;
}
function clearAlert() {
    document.getElementById('alert').className = 'alert';
}
</script>
</body>
</html>