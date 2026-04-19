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
        $request->validate(['status' => 'required|in:approved,rejected']);

        $student = DB::table('students')->where('id', $id)->first();
        if (!$student) return response()->json(['success' => false, 'message' => 'Not found.'], 404);

        DB::table('students')->where('id', $id)->update([
            'status'     => $request->status,
            'updated_at' => now(),
        ]);

        if ($student->user_id) {
            DB::table('users')->where('id', $student->user_id)->update([
                'status' => $request->status,
            ]);
        }

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