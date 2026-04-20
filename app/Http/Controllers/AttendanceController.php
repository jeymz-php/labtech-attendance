<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('realtime_attendance');
    }

    public function verify(Request $request)
    {
        $request->validate(['student_number' => 'required|string|max:30']);

        // Set Manila timezone for all time operations
        $now   = Carbon::now('Asia/Manila');
        $today = Carbon::today('Asia/Manila');

        $sn      = trim($request->student_number);
        $student = DB::table('students')->where('student_number', $sn)->first();

        // ── NOT FOUND ──────────────────────────────────────
        if (!$student) {
            $archived = DB::table('archived_students')->where('student_number', $sn)->first();
            if ($archived) {
                return response()->json([
                    'status'  => 'rejected',
                    'message' => 'This student number has been rejected. Please approach the Administrator or Team Leader for assistance.',
                ], 403);
            }
            return response()->json([
                'status'  => 'not_found',
                'message' => 'Student number not found.',
            ], 404);
        }

        // ── PENDING ────────────────────────────────────────
        if ($student->status === 'pending') {
            return response()->json([
                'status'  => 'pending',
                'message' => 'Your account is still pending approval. Please approach the Administrator or Team Leader.',
                'name'    => $student->name,
            ], 403);
        }

        // ── REJECTED ───────────────────────────────────────
        if ($student->status === 'rejected') {
            return response()->json([
                'status'  => 'rejected',
                'message' => 'Your registration has been rejected. Please approach the Administrator or Team Leader for assistance.',
                'name'    => $student->name,
            ], 403);
        }

        // ── CHECK SYSTEM STATUS ────────────────────────────────────
        $settings = DB::table('office_hours_settings')->first();
        if ($settings) {
            $nowManila  = Carbon::now('Asia/Manila');
            $isSunday   = $nowManila->dayOfWeek === 0;
            $workDays   = json_decode($settings->work_days, true);
            $currentTime = $nowManila->format('H:i');

            $systemOpen = false;
            if ($isSunday) {
                $systemOpen = false;
            } elseif ($settings->is_manually_open) {
                $systemOpen = true;
            } elseif ($settings->is_manually_closed) {
                $systemOpen = false;
            } else {
                $systemOpen = in_array($nowManila->dayOfWeek, $workDays)
                    && $currentTime >= $settings->time_open
                    && $currentTime < $settings->time_close;
            }

            if (!$systemOpen) {
                $reason = $isSunday
                    ? 'Attendance is closed on Sundays.'
                    : ($settings->is_manually_closed
                        ? 'Attendance has been closed by the Administrator.'
                        : 'Attendance is currently outside office hours.');
                return response()->json([
                    'status'  => 'closed',
                    'message' => $reason,
                ], 403);
            }
        }

        // ── APPROVED: Time In / Time Out ───────────────────
        $attendance = DB::table('attendances')
            ->where('student_id', $student->id)
            ->whereDate('created_at', $today)
            ->first();

        if (!$attendance) {
            $timeIn = $now->format('h:i:s A');
            DB::table('attendances')->insert([
                'student_id'     => $student->id,
                'student_number' => $student->student_number,
                'name'           => $student->name,
                'course'         => $student->course ?? null,
                'campus'         => $student->campus ?? null,
                'time_in'        => $timeIn,
                'created_at'     => $now,
                'updated_at'     => $now,
            ]);
            return response()->json([
                'status'  => 'time_in',
                'message' => 'Time In recorded successfully!',
                'student' => [
                    'name'       => $student->name,
                    'course'     => $student->course,
                    'campus'     => $student->campus,
                    'year_level' => $student->year_level,
                ],
                'time' => $timeIn,
            ]);
        }

        if ($attendance->time_in && !$attendance->time_out) {
            $timeOut = $now->format('h:i:s A');
            DB::table('attendances')
                ->where('id', $attendance->id)
                ->update(['time_out' => $timeOut, 'updated_at' => $now]);
            return response()->json([
                'status'  => 'time_out',
                'message' => 'Time Out recorded. See you next time!',
                'student' => [
                    'name'       => $student->name,
                    'course'     => $student->course,
                    'campus'     => $student->campus,
                    'year_level' => $student->year_level,
                ],
                'time_in'  => $attendance->time_in,
                'time_out' => $timeOut,
            ]);
        }

        return response()->json([
            'status'   => 'already_done',
            'message'  => 'You have already completed your time-in and time-out for today.',
            'student'  => [
                'name'       => $student->name,
                'course'     => $student->course,
                'campus'     => $student->campus,
                'year_level' => $student->year_level,
            ],
            'time_in'  => $attendance->time_in,
            'time_out' => $attendance->time_out,
        ]);
    }

    public function officeHours()
    {
        $settings = DB::table('office_hours_settings')->first();

        if (!$settings) {
            return response()->json([
                'work_days'         => [1,2,3,4,5],
                'time_open'         => '08:00',
                'time_close'        => '17:00',
                'is_manually_open'  => false,
                'is_manually_closed'=> false,
                'note'              => null,
                'is_open'           => false,
                'status_label'      => 'Closed',
            ]);
        }

        $now        = Carbon::now('Asia/Manila');
        $dayOfWeek  = (int) $now->dayOfWeek; // 0=Sun, 6=Sat
        $workDays   = json_decode($settings->work_days, true);
        $isSunday   = $dayOfWeek === 0;

        // Sunday → always closed, no manual override
        if ($isSunday) {
            $isOpen      = false;
            $statusLabel = 'Closed — Sunday';
        } elseif ($settings->is_manually_closed) {
            $isOpen      = false;
            $statusLabel = 'Manually Closed by Admin';
        } elseif ($settings->is_manually_open) {
            $isOpen      = true;
            $statusLabel = 'Manually Opened by Admin';
        } else {
            $isWorkday   = in_array($dayOfWeek, $workDays);
            $currentTime = $now->format('H:i');
            $isOpen      = $isWorkday && $currentTime >= $settings->time_open && $currentTime < $settings->time_close;
            $statusLabel = $isOpen ? 'Open' : 'Closed';
        }

        // Format display hours
        $openFormatted  = Carbon::createFromFormat('H:i', $settings->time_open)->format('g:i A');
        $closeFormatted = Carbon::createFromFormat('H:i', $settings->time_close)->format('g:i A');

        $dayNames = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        $workDayNames = array_map(fn($d) => $dayNames[$d], $workDays);

        return response()->json([
            'work_days'          => $workDays,
            'work_day_names'     => $workDayNames,
            'time_open'          => $settings->time_open,
            'time_close'         => $settings->time_close,
            'time_open_display'  => $openFormatted,
            'time_close_display' => $closeFormatted,
            'is_manually_open'   => (bool) $settings->is_manually_open,
            'is_manually_closed' => (bool) $settings->is_manually_closed,
            'note'               => $settings->note,
            'is_open'            => $isOpen,
            'is_sunday'          => $isSunday,
            'status_label'       => $statusLabel,
            'updated_by'         => $settings->updated_by,
            'updated_at'         => $settings->updated_at,
        ]);
    }

    public function recent()
    {
        $records = DB::table('attendances')
            ->whereDate('created_at', Carbon::today())
            ->orderByDesc('created_at')
            ->limit(20)
            ->get(['name', 'student_number', 'course', 'campus', 'time_in', 'time_out']);

        return response()->json($records);
    }
}