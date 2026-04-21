<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function dashboard()
    {
        $user    = Auth::user();
        $student = DB::table('students')->where('user_id', $user->id)->first();

        $records = $student
            ? DB::table('attendances')
                ->where('student_id', $student->id)
                ->where('created_at', '>=', Carbon::now('Asia/Manila')->subDays(30))
                ->orderByDesc('created_at')
                ->get()
            : collect();

        $todayLogged = $student
            ? DB::table('attendances')
                ->where('student_id', $student->id)
                ->whereDate('created_at', Carbon::today('Asia/Manila'))
                ->exists()
            : false;

        return view('student.dashboard', compact('user', 'student', 'records', 'todayLogged'));
    }

    public function uploadPicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:3072',
        ]);

        $user = Auth::user();

        // Delete old picture
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        $path = $request->file('profile_picture')->store('profile_pictures', 'public');

        DB::table('users')->where('id', $user->id)->update([
            'profile_picture' => $path,
            'updated_at'      => now(),
        ]);

        return response()->json([
            'success' => true,
            'url'     => Storage::url($path),
            'message' => 'Profile picture updated successfully.',
        ]);
    }

    public function removePicture(Request $request)
    {
        $user = Auth::user();

        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
            DB::table('users')->where('id', $user->id)->update([
                'profile_picture' => null,
                'updated_at'      => now(),
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Profile picture removed.']);
    }

    public function exportPdf(Request $request)
    {
        $user    = Auth::user();
        $student = DB::table('students')->where('user_id', $user->id)->first();

        $records = $student
            ? DB::table('attendances')
                ->where('student_id', $student->id)
                ->orderByDesc('created_at')
                ->get()
            : collect();

        return view('student.export_pdf', compact('user', 'student', 'records'));
    }
}