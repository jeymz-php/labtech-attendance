<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - UCC LabTech Attendance</title>
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
            --text-dark:   #1b1b1b;
            --text-mid:    #4a4a4a;
            --text-muted:  #888;
            --white:       #ffffff;
            --radius:      12px;
            --shadow:      0 8px 32px rgba(0,0,0,.12);
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
            box-shadow: var(--shadow);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 600px;
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
        }
        .left-panel h2 { font-size: 28px; font-weight: 700; margin-bottom: 10px; line-height: 1.2; }
        .left-panel p  { font-size: 14px; opacity: .75; margin-bottom: 32px; }

        .features { list-style: none; display: flex; flex-direction: column; gap: 14px; }
        .features li {
            display: flex; align-items: center; gap: 12px;
            font-size: 14px; opacity: .9;
        }
        .features li::before {
            content: '';
            width: 22px; height: 22px; border-radius: 50%;
            background: rgba(255,255,255,.2);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='20 6 9 17 4 12'/%3E%3C/svg%3E");
            background-size: 13px; background-repeat: no-repeat; background-position: center;
        }

        /* ── RIGHT PANEL ── */
        .right-panel {
            padding: 36px 40px;
            overflow-y: auto;
            max-height: 80vh;
        }

        .staff-btn {
            display: inline-flex; align-items: center; gap: 8px;
            border: 1.5px solid var(--green-border);
            background: var(--green-pale);
            color: var(--green-main);
            border-radius: 8px;
            padding: 8px 16px;
            font-family: inherit; font-size: 13px; font-weight: 600;
            cursor: pointer;
            margin-bottom: 20px;
            transition: background .2s;
        }
        .staff-btn:hover { background: var(--green-border); }
        .staff-btn svg  { width: 16px; height: 16px; }

        .right-panel h1 { font-size: 24px; font-weight: 700; margin-bottom: 4px; }
        .right-panel .sub { font-size: 13px; color: var(--text-muted); margin-bottom: 24px; }

        /* ── STEPPER ── */
        .stepper {
            display: flex; align-items: center;
            gap: 0; margin-bottom: 28px;
        }
        .step-item {
            display: flex; flex-direction: column; align-items: center; gap: 4px;
            flex: 1; position: relative;
        }
        .step-item:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 14px; left: 50%; width: 100%;
            height: 2px;
            background: var(--green-border);
            z-index: 0;
        }
        .step-item.done::after  { background: var(--green-main); }
        .step-circle {
            width: 28px; height: 28px; border-radius: 50%;
            background: #eee; color: #aaa;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700;
            position: relative; z-index: 1;
            transition: all .3s;
        }
        .step-item.active .step-circle { background: var(--green-main); color: var(--white); }
        .step-item.done   .step-circle { background: var(--green-main); color: var(--white); }
        .step-label { font-size: 11px; color: var(--text-muted); font-weight: 500; }
        .step-item.active .step-label { color: var(--green-main); font-weight: 600; }

        /* ── FORM ── */
        .step-form { display: none; }
        .step-form.active { display: block; }

        .form-section-title {
            font-size: 14px; font-weight: 600; color: var(--green-main);
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 18px;
        }
        .form-section-title svg { width: 16px; height: 16px; }

        .form-group { margin-bottom: 16px; }
        .form-label {
            font-size: 12px; font-weight: 600; color: var(--text-mid);
            display: flex; align-items: center; gap: 6px; margin-bottom: 6px;
        }
        .form-label svg { width: 14px; height: 14px; color: var(--green-main); }

        .form-input, .form-select {
            width: 100%;
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            padding: 11px 14px;
            font-family: inherit; font-size: 14px; color: var(--text-dark);
            outline: none; background: #fafafa;
            transition: border-color .2s, box-shadow .2s;
            appearance: none;
        }
        .form-input:focus, .form-select:focus {
            border-color: var(--green-main);
            box-shadow: 0 0 0 3px rgba(46,125,50,.1);
            background: var(--white);
        }
        .form-input.error { border-color: #e53935; }
        .form-input::placeholder { color: #bbb; }
        .form-hint { font-size: 11px; color: var(--text-muted); margin-top: 4px; }

        /* row */
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

        /* campus grid */
        .campus-section {
            border: 1.5px dashed var(--green-border);
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 16px;
            background: var(--green-pale);
        }
        .campus-label {
            font-size: 12px; font-weight: 600; color: var(--green-main);
            display: flex; align-items: center; gap: 6px; margin-bottom: 12px;
        }
        .campus-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 10px;
        }
        .campus-card {
            border: 1.5px solid var(--green-border);
            border-radius: 10px; padding: 14px 10px;
            background: var(--white); text-align: center;
            cursor: pointer; transition: all .2s;
        }
        .campus-card:hover { border-color: var(--green-main); background: #f1faf2; }
        .campus-card.selected {
            border-color: var(--green-main);
            background: #e8f5e9;
            box-shadow: 0 0 0 3px rgba(46,125,50,.1);
        }
        .campus-card svg { width: 28px; height: 28px; color: var(--green-main); margin-bottom: 6px; }
        .campus-card .campus-name { font-size: 13px; font-weight: 600; }
        .campus-card .campus-suffix { font-size: 11px; color: var(--text-muted); }

        /* password strength */
        .pw-strength { margin-top: 6px; display: flex; gap: 4px; }
        .pw-bar {
            height: 3px; flex: 1; border-radius: 2px; background: #eee;
            transition: background .3s;
        }
        .pw-bar.weak   { background: #e53935; }
        .pw-bar.fair   { background: #fb8c00; }
        .pw-bar.strong { background: var(--green-main); }

        /* checkbox */
        .check-row { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 20px; margin-top: 4px; }
        .check-row input[type=checkbox] { width: 16px; height: 16px; margin-top: 2px; accent-color: var(--green-main); flex-shrink: 0; }
        .check-row label { font-size: 13px; color: var(--text-mid); line-height: 1.5; }
        .check-row a { color: var(--green-main); font-weight: 600; text-decoration: none; }

        /* buttons */
        .btn-row { display: flex; gap: 10px; }
        .btn-prev {
            border: 1.5px solid var(--green-border);
            background: var(--white); color: var(--green-main);
            border-radius: 8px; padding: 12px 20px;
            font-family: inherit; font-size: 14px; font-weight: 600;
            cursor: pointer; display: flex; align-items: center; gap: 6px;
            transition: background .2s;
        }
        .btn-prev:hover { background: var(--green-pale); }
        .btn-next {
            background: var(--green-main); color: var(--white);
            border: none; border-radius: 8px; padding: 12px 28px;
            font-family: inherit; font-size: 14px; font-weight: 600;
            cursor: pointer; display: flex; align-items: center; gap: 8px;
            transition: background .2s;
        }
        .btn-next:hover { background: var(--green-mid); }
        .btn-next:disabled { opacity: .6; cursor: not-allowed; }
        .btn-next svg, .btn-prev svg { width: 16px; height: 16px; }

        .divider { border: none; border-top: 1px dashed #e0e0e0; margin: 20px 0; }

        .signin-row { text-align: center; }
        .signin-btn {
            display: inline-flex; align-items: center; gap: 8px;
            border: 1.5px solid var(--green-border);
            background: var(--white); color: var(--green-main);
            border-radius: 8px; padding: 10px 20px;
            font-family: inherit; font-size: 13px; font-weight: 600;
            cursor: pointer; text-decoration: none;
            transition: background .2s;
        }
        .signin-btn:hover { background: var(--green-pale); }

        /* alert */
        .alert {
            padding: 12px 14px; border-radius: 8px; font-size: 13px;
            margin-bottom: 16px; display: none;
        }
        .alert.error   { background: #fff5f5; border: 1px solid #ffcdd2; color: #c62828; display: block; }
        .alert.success { background: #f1faf2; border: 1px solid var(--green-border); color: var(--green-dark); display: block; }

        /* footer */
        .page-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: rgba(255,255,255,.7);
        }

        @media (max-width: 640px) {
            .container { grid-template-columns: 1fr; }
            .left-panel { display: none; }
            .right-panel { padding: 28px 20px; max-height: none; }
        }
    </style>
</head>
<body>

<div style="width:100%; max-width:900px;">
    <div class="container">

        <!-- LEFT PANEL -->
        <div class="left-panel">
            <div class="school-logo">UCC</div>
            <h2>Join UCC LabTech</h2>
            <p>Create your account to start tracking attendance</p>
            <ul class="features">
                <li>Easy time-in/time-out tracking</li>
                <li>View your attendance history</li>
                <li>Get notified of late entries</li>
                <li>Access from any device</li>
            </ul>
        </div>

        <!-- RIGHT PANEL -->
        <div class="right-panel">

            <!-- Staff toggle -->
            <button class="staff-btn" onclick="toggleRole(this)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                <span id="roleLabel">Staff Registration</span>
            </button>

            <div id="formHeader">
                <h1>Create Account</h1>
                <p class="sub">Fill in your details to register</p>
            </div>

            <div id="alert" class="alert"></div>

            <!-- Stepper -->
            <div class="stepper">
                <div class="step-item active" id="step-ind-1">
                    <div class="step-circle">1</div>
                    <div class="step-label">Personal</div>
                </div>
                <div class="step-item" id="step-ind-2">
                    <div class="step-circle">2</div>
                    <div class="step-label">Academic</div>
                </div>
                <div class="step-item" id="step-ind-3">
                    <div class="step-circle">3</div>
                    <div class="step-label">Account</div>
                </div>
            </div>

            <!-- STEP 1: Personal -->
            <div class="step-form active" id="step-1">
                <div class="form-section-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Personal Information
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Full Name
                    </div>
                    <input class="form-input" id="fullName" type="text" placeholder="Enter your complete name">
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.79 19.79 0 01.01 1.18 2 2 0 012 0h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 14v2.92z"/></svg>
                        Phone Number
                    </div>
                    <input class="form-input" id="phone" type="tel" placeholder="e.g., 09123456789" maxlength="11">
                </div>

                <div class="btn-row">
                    <button class="btn-next" onclick="goStep(2)">
                        Next
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </button>
                </div>

                <hr class="divider">
                <div class="signin-row">
                    <p style="font-size:13px;color:var(--text-muted);margin-bottom:10px;">Already have an account?</p>
                    <a href="{{ route('login') }}" class="signin-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                        Sign In Instead
                    </a>
                </div>
            </div>

            <!-- STEP 2: Academic -->
            <div class="step-form" id="step-2">
                <div class="form-section-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Academic Information
                </div>

                <!-- Campus -->
                <div class="campus-section">
                    <div class="campus-label">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        Select Your Campus
                    </div>
                    <div class="campus-grid">
                        <div class="campus-card" onclick="selectCampus(this,'South Campus','S')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 3a2.828 2.828 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                            <div class="campus-name">South Campus</div>
                            <div class="campus-suffix">Suffix: - S</div>
                        </div>
                        <div class="campus-card" onclick="selectCampus(this,'Congressional','N')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                            <div class="campus-name">Congressional</div>
                            <div class="campus-suffix">Suffix: - N</div>
                        </div>
                        <div class="campus-card" onclick="selectCampus(this,'Camarin','N')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>
                            <div class="campus-name">Camarin</div>
                            <div class="campus-suffix">Suffix: - N</div>
                        </div>
                        <div class="campus-card" onclick="selectCampus(this,'Bagong Silang','N')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                            <div class="campus-name">Bagong Silang</div>
                            <div class="campus-suffix">Suffix: - N</div>
                        </div>
                    </div>
                    <input type="hidden" id="campus" value="">
                    <input type="hidden" id="campusSuffix" value="">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <div class="form-label">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                            Course
                        </div>
                        <select class="form-select" id="course">
                            <option value="">Select Course</option>
                            <option>BSIT</option>
                            <option>BSCS</option>
                            <option>BSIS</option>
                            <option>BSECE</option>
                            <option>BSED</option>
                            <option>BSBA</option>
                            <option>BSCRIM</option>
                            <option>BSN</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="form-label">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/></svg>
                            Year Level
                        </div>
                        <select class="form-select" id="yearLevel">
                            <option value="">Select Year</option>
                            <option>1st Year</option>
                            <option>2nd Year</option>
                            <option>3rd Year</option>
                            <option>4th Year</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                        Student Number (8 digits)
                    </div>
                    <input class="form-input" id="studentNumber" type="text" placeholder="e.g., 20261234" maxlength="8">
                    <div class="form-hint" id="studentNumberPreview">Enter 8 digits only (e.g., 20261234)</div>
                </div>

                <div class="btn-row">
                    <button class="btn-prev" onclick="goStep(1)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                        Previous
                    </button>
                    <button class="btn-next" onclick="goStep(3)">
                        Next
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </button>
                </div>
            </div>

            <!-- STEP 3: Account -->
            <div class="step-form" id="step-3">
                <div class="form-section-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    Account Information
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        Email Address
                    </div>
                    <input class="form-input" id="email" type="email" placeholder="name@example.com">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <div class="form-label">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 11-7.778 7.778 5.5 5.5 0 017.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/></svg>
                            Password
                        </div>
                        <input class="form-input" id="password" type="password" placeholder="Create a password" oninput="checkStrength(this.value)">
                        <div class="pw-strength">
                            <div class="pw-bar" id="bar1"></div>
                            <div class="pw-bar" id="bar2"></div>
                            <div class="pw-bar" id="bar3"></div>
                            <div class="pw-bar" id="bar4"></div>
                        </div>
                        <div class="form-hint" id="pwHint">Enter password</div>
                    </div>
                    <div class="form-group">
                        <div class="form-label">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            Confirm Password
                        </div>
                        <input class="form-input" id="confirmPassword" type="password" placeholder="Confirm your password">
                    </div>
                </div>

                <div class="check-row">
                    <input type="checkbox" id="terms">
                    <label for="terms">
                        I agree to the <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>
                    </label>
                </div>

                <div class="btn-row">
                    <button class="btn-prev" onclick="goStep(2)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                        Previous
                    </button>
                    <button class="btn-next" id="submitBtn" onclick="submitForm()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                        Create Account
                    </button>
                </div>
            </div>

        </div><!-- end right-panel -->
    </div><!-- end container -->

    <div class="page-footer">© {{ date('Y') }} UCC LabTech Attendance System</div>
</div>

<script>
let currentStep = 1;
let isStaff = false;
let selectedCampus = '';
let selectedSuffix = '';

// Pre-fill student number from URL
const urlParams = new URLSearchParams(window.location.search);
const preStudentNum = urlParams.get('student_number');
if (preStudentNum) {
    // strip suffix, keep digits only
    const digits = preStudentNum.replace(/\D/g, '').substring(0, 8);
    document.getElementById('studentNumber').value = digits;
}

function toggleRole(btn) {
    isStaff = !isStaff;
    document.getElementById('roleLabel').textContent = isStaff ? 'Student Registration' : 'Staff Registration';
    // Hide academic step for staff
    document.getElementById('step-ind-2').style.opacity = isStaff ? '.4' : '1';
}

function goStep(n) {
    if (n > currentStep && !validateStep(currentStep)) return;

    document.getElementById('step-' + currentStep).classList.remove('active');
    document.getElementById('step-ind-' + currentStep).classList.remove('active');
    if (n > currentStep) document.getElementById('step-ind-' + currentStep).classList.add('done');
    else document.getElementById('step-ind-' + currentStep).classList.remove('done');

    currentStep = n;
    document.getElementById('step-' + currentStep).classList.add('active');
    document.getElementById('step-ind-' + currentStep).classList.add('active');

    clearAlert();
}

function validateStep(step) {
    if (step === 1) {
        const name  = document.getElementById('fullName').value.trim();
        const phone = document.getElementById('phone').value.trim();
        if (!name)  { showAlert('Please enter your full name.'); return false; }
        if (!phone) { showAlert('Please enter your phone number.'); return false; }
    }
    if (step === 2) {
        if (!selectedCampus) { showAlert('Please select your campus.'); return false; }
        if (!document.getElementById('course').value)     { showAlert('Please select your course.'); return false; }
        if (!document.getElementById('yearLevel').value)  { showAlert('Please select your year level.'); return false; }
        const sn = document.getElementById('studentNumber').value.trim();
        if (!/^\d{8}$/.test(sn)) { showAlert('Student number must be exactly 8 digits.'); return false; }
    }
    return true;
}

function selectCampus(card, name, suffix) {
    document.querySelectorAll('.campus-card').forEach(c => c.classList.remove('selected'));
    card.classList.add('selected');
    selectedCampus = name;
    selectedSuffix = suffix;
    document.getElementById('campus').value = name;
    document.getElementById('campusSuffix').value = suffix;
    updateStudentPreview();
}

document.getElementById('studentNumber').addEventListener('input', updateStudentPreview);
function updateStudentPreview() {
    const sn = document.getElementById('studentNumber').value.trim();
    const sfx = selectedSuffix ? ' - ' + selectedSuffix : '';
    document.getElementById('studentNumberPreview').textContent =
        sn ? 'Full student number: ' + sn + sfx : 'Enter 8 digits only (e.g., 20261234)';
}

function checkStrength(pw) {
    const bars = [document.getElementById('bar1'), document.getElementById('bar2'),
                  document.getElementById('bar3'), document.getElementById('bar4')];
    bars.forEach(b => b.className = 'pw-bar');
    let score = 0;
    if (pw.length >= 8) score++;
    if (/[A-Z]/.test(pw)) score++;
    if (/[0-9]/.test(pw)) score++;
    if (/[^A-Za-z0-9]/.test(pw)) score++;
    const cls = score <= 1 ? 'weak' : score <= 2 ? 'fair' : 'strong';
    const labels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
    document.getElementById('pwHint').textContent = pw ? labels[score] || 'Weak' : 'Enter password';
    for (let i = 0; i < score; i++) bars[i].classList.add(cls);
}

async function submitForm() {
    if (!validateStep(3)) return;
    const email = document.getElementById('email').value.trim();
    const pw    = document.getElementById('password').value;
    const cpw   = document.getElementById('confirmPassword').value;
    const terms = document.getElementById('terms').checked;
    if (!email) { showAlert('Please enter your email.'); return; }
    if (pw.length < 8) { showAlert('Password must be at least 8 characters.'); return; }
    if (pw !== cpw)    { showAlert('Passwords do not match.'); return; }
    if (!terms)        { showAlert('Please agree to the Terms and Conditions.'); return; }

    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.textContent = 'Creating account...';

    const payload = {
        name:           document.getElementById('fullName').value.trim(),
        phone:          document.getElementById('phone').value.trim(),
        campus:         selectedCampus,
        campus_suffix:  selectedSuffix,
        course:         document.getElementById('course').value,
        year_level:     document.getElementById('yearLevel').value,
        student_number: document.getElementById('studentNumber').value.trim() + (selectedSuffix ? '-' + selectedSuffix : ''),
        email,
        password:       pw,
        role:           isStaff ? 'staff' : 'student',
        _token:         '{{ csrf_token() }}',
    };

    try {
        const res  = await fetch('{{ route("register.store") }}', {
            method : 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body   : JSON.stringify(payload),
        });
        const data = await res.json();
        if (data.success) {
            showAlert(data.message ?? 'Account created! Awaiting approval.', 'success');
            setTimeout(() => window.location.href = '/', 2500);
        } else {
            showAlert(data.message ?? 'Registration failed. Please try again.');
        }
    } catch (e) {
        showAlert('Network error. Please try again.');
    }

    btn.disabled = false;
    btn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg> Create Account`;
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