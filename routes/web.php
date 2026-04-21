<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SuperAdminController;

// ── PUBLIC ─────────────────────────────────────────────────
Route::get('/',                   [AttendanceController::class, 'index'])->name('home');
Route::get('/realtime_attendance',[AttendanceController::class, 'index'])->name('attendance.index');
Route::post('/attendance/verify', [AttendanceController::class, 'verify'])->name('attendance.verify');
Route::get('/attendance/recent',  [AttendanceController::class, 'recent'])->name('attendance.recent');
Route::get('/office-hours',       [AttendanceController::class, 'officeHours'])->name('office_hours.public');

// ── AUTH ───────────────────────────────────────────────────
Route::get('/auth/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/auth/login',   [AuthController::class, 'login'])->name('login.post');
Route::get('/auth/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/auth/register',[AuthController::class, 'store'])->name('register.store');
Route::post('/auth/logout',  [AuthController::class, 'logout'])->name('logout');

// ── STUDENT/STAFF DASHBOARD ────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard',                        [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::post('/profile/picture',                 [StudentController::class, 'uploadPicture'])->name('profile.picture');
    Route::delete('/profile/picture',               [StudentController::class, 'removePicture'])->name('profile.picture.remove');
    Route::get('/dashboard/export-pdf',             [StudentController::class, 'exportPdf'])->name('student.export_pdf');
});

// ── SUPER ADMIN ────────────────────────────────────────────
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/',                                    [SuperAdminController::class, 'index'])->name('admin.index');
    Route::get('/registrations',                       [SuperAdminController::class, 'registrations'])->name('admin.registrations');
    Route::patch('/registrations/{id}/status',         [SuperAdminController::class, 'updateStatus'])->name('admin.registrations.status');
    Route::get('/attendance',                          [SuperAdminController::class, 'attendanceData'])->name('admin.attendance');
    Route::get('/stats',                               [SuperAdminController::class, 'stats'])->name('admin.stats');
    Route::get('/archived',                            [SuperAdminController::class, 'archived'])->name('admin.archived');
    Route::patch('/archived/{id}/restore',             [SuperAdminController::class, 'restoreArchived'])->name('admin.archived.restore');
    Route::get('/settings/office-hours',               [SuperAdminController::class, 'getOfficeHours'])->name('admin.office_hours.get');
    Route::post('/settings/office-hours',              [SuperAdminController::class, 'saveOfficeHours'])->name('admin.office_hours.save');
    Route::post('/settings/attendance/toggle',         [SuperAdminController::class, 'toggleAttendance'])->name('admin.attendance.toggle');
    Route::patch('/users/{id}/toggle-active',          [SuperAdminController::class, 'toggleActive'])->name('admin.users.toggle_active');
});