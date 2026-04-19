<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['success' => false, 'message' => 'Invalid email or password.'], 401);
        }

        $user = Auth::user();

        if ($user->status === 'pending') {
            Auth::logout();
            return response()->json(['success' => false, 'message' => 'Your account is still pending approval. Please wait for admin review.'], 403);
        }

        if ($user->status === 'rejected') {
            Auth::logout();
            return response()->json(['success' => false, 'message' => 'Your account has been rejected. Please contact the administrator.'], 403);
        }

        $request->session()->regenerate();

        return response()->json([
            'success'  => true,
            'redirect' => $this->redirectByRole($user, true),
        ]);
    }

    private function redirectByRole($user, $returnUrl = false)
    {
        $url = match($user->role) {
            'super_admin' => route('admin.index'),
            default       => route('student.dashboard'),
        };
        return $returnUrl ? $url : redirect($url);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:100',
            'phone'          => 'required|string|max:15',
            'campus'         => 'required|string',
            'campus_suffix'  => 'required|string',
            'course'         => 'nullable|string',
            'year_level'     => 'nullable|string',
            'student_number' => 'required|string|unique:students,student_number',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|min:8',
            'role'           => 'required|in:student,staff,practicumer,team-leader',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'phone'    => $request->phone,
            'role'     => $request->role,
            'status'   => 'pending',
        ]);

        DB::table('students')->insert([
            'student_number' => $request->student_number,
            'name'           => $request->name,
            'phone'          => $request->phone,
            'campus'         => $request->campus,
            'course'         => $request->course ?? null,
            'year_level'     => $request->year_level ?? null,
            'user_id'        => $user->id,
            'status'         => 'pending',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Account created! Please wait for admin approval before logging in.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}