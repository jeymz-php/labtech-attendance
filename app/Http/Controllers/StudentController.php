<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function dashboard()
    {
        $user    = Auth::user();
        $student = DB::table('students')->where('user_id', $user->id)->first();

        // Last 30 days attendance
        $records = $student
            ? DB::table('attendances')
                ->where('student_id', $student->id)
                ->where('created_at', '>=', Carbon::now()->subDays(30))
                ->orderByDesc('created_at')
                ->get()
            : collect();

        $todayLogged = $student
            ? DB::table('attendances')
                ->where('student_id', $student->id)
                ->whereDate('created_at', Carbon::today())
                ->exists()
            : false;

        return view('student.dashboard', compact('user', 'student', 'records', 'todayLogged'));
    }
}