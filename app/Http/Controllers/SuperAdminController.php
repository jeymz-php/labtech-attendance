<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SuperAdminController extends Controller
{
    public function index()
    {
        // Only super_admin allowed
        if (auth()->user()->role !== 'super_admin') {
            abort(403);
        }
        return view('admin.super_admin');
    }

    public function registrations()
    {
        $records = DB::table('students')
            ->leftJoin('users', 'students.user_id', '=', 'users.id')
            ->select(
                'students.id', 'students.student_number', 'students.name',
                'students.phone', 'students.campus', 'students.course',
                'students.year_level', 'students.status', 'students.created_at',
                'users.email', 'users.role'
            )
            ->orderByDesc('students.created_at')
            ->get();

        return response()->json($records);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending'  // ← added pending
        ]);

        $student = DB::table('students')->where('id', $id)->first();
        if (!$student) {
            return response()->json(['success' => false, 'message' => 'Not found.'], 404);
        }

        DB::table('students')->where('id', $id)->update([
            'status'     => $request->status,
            'updated_at' => now(),
        ]);

        if ($student->user_id) {
            DB::table('users')->where('id', $student->user_id)->update([
                'status' => $request->status,
            ]);
        }

        // ── REJECTED → archive ─────────────────────────────
        if ($request->status === 'rejected') {
            $user   = $student->user_id ? DB::table('users')->where('id', $student->user_id)->first() : null;
            $exists = DB::table('archived_students')->where('original_student_id', $id)->exists();
            if (!$exists) {
                DB::table('archived_students')->insert([
                    'original_student_id' => $id,
                    'user_id'             => $student->user_id ?? null,
                    'student_number'      => $student->student_number,
                    'name'                => $student->name,
                    'email'               => $user->email ?? null,
                    'phone'               => $student->phone ?? null,
                    'campus'              => $student->campus ?? null,
                    'course'              => $student->course ?? null,
                    'year_level'          => $student->year_level ?? null,
                    'role'                => $user->role ?? 'student',
                    'reason'              => 'rejected',
                    'created_at'          => now(),
                    'updated_at'          => now(),
                ]);
            }
        }

        // ── REVERTED (pending or approved) → remove from archive ──
        if (in_array($request->status, ['pending', 'approved'])) {
            DB::table('archived_students')->where('original_student_id', $id)->delete();
        }

        return response()->json(['success' => true]);
    }

    public function archived()
    {
        $records = DB::table('archived_students')->orderByDesc('created_at')->get();
        return response()->json($records);
    }

    public function restoreArchived(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:pending,approved'
        ]);

        $archived = DB::table('archived_students')->where('id', $id)->first();
        if (!$archived) {
            return response()->json(['success' => false, 'message' => 'Archived record not found.'], 404);
        }

        // Update student status back
        DB::table('students')
            ->where('id', $archived->original_student_id)
            ->update([
                'status'     => $request->action,
                'updated_at' => now(),
            ]);

        // Update user status too
        if ($archived->user_id) {
            DB::table('users')
                ->where('id', $archived->user_id)
                ->update(['status' => $request->action]);
        }

        // Remove from archive
        DB::table('archived_students')->where('id', $id)->delete();

        return response()->json(['success' => true]);
    }

    public function attendanceData(Request $request)
    {
        $date  = $request->get('date', Carbon::today()->toDateString());
        $search = $request->get('search', '');

        $query = DB::table('attendances')
            ->whereDate('created_at', $date)
            ->orderByDesc('created_at');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('student_number', 'like', "%$search%");
            });
        }

        return response()->json($query->get());
    }

    public function getOfficeHours()
    {
        $settings = DB::table('office_hours_settings')->first();
        return response()->json($settings);
    }

    public function saveOfficeHours(Request $request)
    {
        $request->validate([
            'work_days'  => 'required|array|min:1',
            'work_days.*'=> 'integer|between:0,6',
            'time_open'  => 'required|date_format:H:i',
            'time_close' => 'required|date_format:H:i|after:time_open',
            'note'       => 'nullable|string|max:500',
        ]);

        // Remove Sunday (0) from work_days — always closed
        $workDays = array_values(array_filter($request->work_days, fn($d) => $d !== 0));

        DB::table('office_hours_settings')->updateOrInsert(
            ['id' => 1],
            [
                'work_days'  => json_encode($workDays),
                'time_open'  => $request->time_open,
                'time_close' => $request->time_close,
                'note'       => $request->note,
                'updated_by' => auth()->user()->name,
                'updated_at' => now(),
            ]
        );

        return response()->json(['success' => true, 'message' => 'Office hours updated successfully.']);
    }

    public function toggleAttendance(Request $request)
    {
        $request->validate(['action' => 'required|in:open,close,auto']);

        $now = Carbon::now('Asia/Manila');

        // Prevent manual open on Sundays
        if ($request->action === 'open' && $now->dayOfWeek === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot manually open attendance on Sundays.',
            ], 403);
        }

        $update = match($request->action) {
            'open'  => ['is_manually_open' => true,  'is_manually_closed' => false],
            'close' => ['is_manually_open' => false, 'is_manually_closed' => true],
            'auto'  => ['is_manually_open' => false, 'is_manually_closed' => false],
        };

        DB::table('office_hours_settings')->where('id', 1)->update(array_merge($update, [
            'updated_by' => auth()->user()->name,
            'updated_at' => now(),
        ]));

        $label = match($request->action) {
            'open'  => 'Attendance manually opened.',
            'close' => 'Attendance manually closed.',
            'auto'  => 'Attendance set back to automatic schedule.',
        };

        return response()->json(['success' => true, 'message' => $label]);
    }

    public function stats()
    {
        $today = Carbon::today()->toDateString();

        return response()->json([
            'today_attendance' => DB::table('attendances')->whereDate('created_at', $today)->count(),
            'total_students'   => DB::table('students')->where('status', 'approved')->count(),
            'pending'          => DB::table('students')->where('status', 'pending')->count(),
            'approved'         => DB::table('students')->where('status', 'approved')->count(),
            'rejected'         => DB::table('students')->where('status', 'rejected')->count(),
            'total'            => DB::table('students')->count(),
        ]);
    }
}