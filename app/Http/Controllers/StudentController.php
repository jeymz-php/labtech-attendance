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

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:100',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        DB::table('users')->where('id', $user->id)->update([
            'name'       => $request->name,
            'phone'      => $request->phone,
            'email'      => $request->email,
            'updated_at' => now(),
        ]);

        // Update name in students table too
        $student = DB::table('students')->where('user_id', $user->id)->first();
        if ($student) {
            DB::table('students')->where('user_id', $user->id)->update([
                'name'       => $request->name,
                'phone'      => $request->phone,
                'updated_at' => now(),
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Profile updated successfully.']);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect.',
            ], 422);
        }

        DB::table('users')->where('id', $user->id)->update([
            'password'   => bcrypt($request->password),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Password changed successfully.']);
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