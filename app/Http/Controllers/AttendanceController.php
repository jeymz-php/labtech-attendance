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
        $request->validate([
            'student_number' => 'required|string|max:30',
        ]);

        $studentNumber = $request->input('student_number');

        // Find student
        $student = DB::table('students')
            ->where('student_number', $studentNumber)
            ->first();

        if (! $student) {
            return response()->json([
                'success' => false,
                'message' => 'Student number not found.',
            ], 404);
        }

        $today = Carbon::today();

        // Check if already logged in today
        $existing = DB::table('attendances')
            ->where('student_id', $student->id)
            ->whereDate('created_at', $today)
            ->first();

        if ($existing) {
            return response()->json([
                'success'   => true,
                'message'   => 'Already logged in today.',
                'student'   => [
                    'name'       => $student->name,
                    'course'     => $student->course ?? null,
                    'year_level' => $student->year_level ?? null,
                ],
                'logged_at' => Carbon::parse($existing->created_at)->format('h:i A'),
            ]);
        }

        // Log attendance
        DB::table('attendances')->insert([
            'student_id'     => $student->id,
            'student_number' => $student->student_number,
            'name'           => $student->name,
            'course'         => $student->course ?? null,
            'time_in'        => now()->format('h:i A'),
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Attendance recorded.',
            'student'   => [
                'name'       => $student->name,
                'course'     => $student->course ?? null,
                'year_level' => $student->year_level ?? null,
            ],
            'logged_at' => now()->format('h:i A'),
        ]);
    }

    public function recent()
    {
        $records = DB::table('attendances')
            ->whereDate('created_at', Carbon::today())
            ->orderByDesc('created_at')
            ->limit(20)
            ->get(['name', 'student_number', 'course', 'time_in']);

        return response()->json($records);
    }
}