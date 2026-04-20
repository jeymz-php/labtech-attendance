<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SuperAdminController;

// ── PUBLIC ─────────────────────────────────────────────────
Route::get('/',                  [AttendanceController::class, 'index'])->name('home');
Route::get('/realtime_attendance',[AttendanceController::class, 'index'])->name('attendance.index');
Route::post('/attendance/verify', [AttendanceController::class, 'verify'])->name('attendance.verify');
Route::get('/attendance/recent',  [AttendanceController::class, 'recent'])->name('attendance.recent');

// ── AUTH ───────────────────────────────────────────────────
Route::get('/auth/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/auth/login',   [AuthController::class, 'login'])->name('login.post');
Route::get('/auth/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/auth/register',[AuthController::class, 'store'])->name('register.store');
Route::post('/auth/logout',  [AuthController::class, 'logout'])->name('logout');

// ── STUDENT DASHBOARD (auth required) ─────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
});

// ── SUPER ADMIN (auth + super_admin role) ─────────────────
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/',                                [SuperAdminController::class, 'index'])->name('admin.index');
    Route::get('/registrations',                   [SuperAdminController::class, 'registrations'])->name('admin.registrations');
    Route::patch('/registrations/{id}/status',     [SuperAdminController::class, 'updateStatus'])->name('admin.registrations.status');
    Route::get('/attendance',                      [SuperAdminController::class, 'attendanceData'])->name('admin.attendance');
    Route::get('/stats',                           [SuperAdminController::class, 'stats'])->name('admin.stats');
    Route::get('/archived',                        [SuperAdminController::class, 'archived'])->name('admin.archived');
    Route::patch('/archived/{id}/restore',         [SuperAdminController::class, 'restoreArchived'])->name('admin.archived.restore'); // ← NEW
    // Inside the admin middleware group
    Route::get('/settings/office-hours',    [SuperAdminController::class, 'getOfficeHours'])->name('admin.office_hours.get');
    Route::post('/settings/office-hours',   [SuperAdminController::class, 'saveOfficeHours'])->name('admin.office_hours.save');
    Route::post('/settings/attendance/toggle', [SuperAdminController::class, 'toggleAttendance'])->name('admin.attendance.toggle');

    // Public route — realtime page needs to fetch settings
    Route::get('/office-hours', [AttendanceController::class, 'officeHours'])->name('office_hours.public');
});