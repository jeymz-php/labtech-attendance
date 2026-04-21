<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Log - {{ $user->name }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Arial, sans-serif; font-size: 12px; color: #1b1b1b; background: #fff; }

        .header { background: #1a4d2e; color: #fff; padding: 24px 32px; display: flex; align-items: center; gap: 16px; }
        .header-logo { width: 60px; height: 60px; background: #fff; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden; }
        .header-logo img { width: 50px; height: 50px; object-fit: contain; }
        .header-title h1 { font-size: 20px; font-weight: 700; }
        .header-title p  { font-size: 12px; opacity: .75; margin-top: 2px; }

        .meta { padding: 20px 32px; border-bottom: 2px solid #e8f5e9; display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; background: #f9f9f9; }
        .meta-item .lbl { font-size: 10px; font-weight: 700; color: #888; text-transform: uppercase; letter-spacing: .5px; }
        .meta-item .val { font-size: 13px; font-weight: 600; margin-top: 2px; color: #1b1b1b; }

        .content { padding: 24px 32px; }
        .section-title { font-size: 13px; font-weight: 700; color: #2e7d32; margin-bottom: 12px; text-transform: uppercase; letter-spacing: .5px; border-bottom: 2px solid #c8e6c9; padding-bottom: 6px; }

        table { width: 100%; border-collapse: collapse; }
        th { background: #2e7d32; color: #fff; text-align: left; padding: 8px 12px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; }
        td { padding: 8px 12px; border-bottom: 1px solid #f0f0f0; font-size: 12px; }
        tr:nth-child(even) td { background: #f9fdf9; }
        tr:last-child td { border-bottom: none; }

        .badge-in   { background: #e8f5e9; color: #2e7d32; padding: 2px 8px; border-radius: 10px; font-weight: 600; font-size: 11px; }
        .badge-out  { background: #e3f2fd; color: #1565c0; padding: 2px 8px; border-radius: 10px; font-weight: 600; font-size: 11px; }
        .badge-none { background: #f5f5f5; color: #bbb; padding: 2px 8px; border-radius: 10px; font-size: 11px; }

        .summary { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; margin-bottom: 20px; }
        .summary-card { background: #f9fdf9; border: 1px solid #c8e6c9; border-radius: 8px; padding: 12px 16px; text-align: center; }
        .summary-card .num { font-size: 24px; font-weight: 700; color: #2e7d32; }
        .summary-card .lbl { font-size: 11px; color: #888; margin-top: 2px; }

        .footer { margin-top: 32px; padding: 16px 32px; border-top: 1px solid #e0e0e0; display: flex; justify-content: space-between; font-size: 11px; color: #888; }

        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="no-print" style="padding:12px 32px;background:#fff3e0;border-bottom:2px solid #ffe082;font-size:13px;display:flex;align-items:center;justify-content:space-between;">
    <span>📄 Click <strong>Print</strong> to save as PDF or print this report.</span>
    <button onclick="window.print()" style="background:#2e7d32;color:#fff;border:none;border-radius:6px;padding:8px 18px;font-size:13px;font-weight:600;cursor:pointer;">🖨️ Print / Save PDF</button>
</div>

<div class="header">
    <div class="header-logo">
        <img src="{{ public_path('images/UCC_Logo.png') }}" alt="UCC Logo"
             onerror="this.style.display='none';this.parentElement.innerHTML='<span style=\'font-weight:700;font-size:14px;color:#2e7d32;\'>UCC</span>'">
    </div>
    <div class="header-title">
        <h1>UCC LabTech Attendance System</h1>
        <p>University of Caloocan City — Attendance Log Report</p>
    </div>
</div>

<div class="meta">
    <div class="meta-item"><div class="lbl">Full Name</div><div class="val">{{ $user->name }}</div></div>
    <div class="meta-item"><div class="lbl">Student Number</div><div class="val">{{ $student->student_number ?? '—' }}</div></div>
    <div class="meta-item"><div class="lbl">Course</div><div class="val">{{ $student->course ?? '—' }}</div></div>
    <div class="meta-item"><div class="lbl">Year Level</div><div class="val">{{ $student->year_level ?? '—' }}</div></div>
    <div class="meta-item"><div class="lbl">Campus</div><div class="val">{{ $student->campus ?? '—' }}</div></div>
    <div class="meta-item"><div class="lbl">Generated On</div><div class="val">{{ \Carbon\Carbon::now('Asia/Manila')->format('M d, Y h:i A') }}</div></div>
</div>

<div class="content">

    <div class="summary">
        <div class="summary-card">
            <div class="num">{{ $records->count() }}</div>
            <div class="lbl">Total Days Logged</div>
        </div>
        <div class="summary-card">
            <div class="num">{{ $records->whereNotNull('time_out')->count() }}</div>
            <div class="lbl">Completed (IN & OUT)</div>
        </div>
        <div class="summary-card">
            <div class="num">{{ $records->whereNull('time_out')->count() }}</div>
            <div class="lbl">No Time-Out Recorded</div>
        </div>
    </div>

    <div class="section-title">Attendance Records</div>

    @if($records->count())
    <table>
        <thead>
            <tr><th>#</th><th>Date</th><th>Day</th><th>Time In</th><th>Time Out</th><th>Duration</th></tr>
        </thead>
        <tbody>
            @foreach($records as $i => $rec)
            @php
                $duration = '—';
                if ($rec->time_in && $rec->time_out) {
                    try {
                        $in   = \Carbon\Carbon::createFromFormat('h:i:s A', $rec->time_in,  'Asia/Manila');
                        $out  = \Carbon\Carbon::createFromFormat('h:i:s A', $rec->time_out, 'Asia/Manila');
                        $mins = $in->diffInMinutes($out);
                        $duration = floor($mins/60).'h '.($mins%60).'m';
                    } catch(\Exception $e) { $duration = '—'; }
                }
            @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($rec->created_at)->format('M d, Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($rec->created_at)->format('l') }}</td>
                <td><span class="badge-in">{{ $rec->time_in ?? '—' }}</span></td>
                <td>@if($rec->time_out)<span class="badge-out">{{ $rec->time_out }}</span>@else<span class="badge-none">No record</span>@endif</td>
                <td>{{ $duration }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p style="color:#888;text-align:center;padding:32px;">No attendance records found.</p>
    @endif

</div>

<div class="footer">
    <span>UCC LabTech Attendance System © {{ date('Y') }} University of Caloocan City</span>
    <span>Generated: {{ \Carbon\Carbon::now('Asia/Manila')->format('F d, Y h:i A') }}</span>
</div>

</body>
</html>