<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

/* ================== ADMIN ================== */
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EmployeeApprovalController;
use App\Http\Controllers\Admin\PayrollApprovalController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\SalarySettingController;

/* ================== HRD ================== */
use App\Http\Controllers\HRD\DashboardController;
use App\Http\Controllers\HRD\EmployeeController;
use App\Http\Controllers\HRD\RfidCardController;
use App\Http\Controllers\HRD\AttendanceReportController;
use App\Http\Controllers\HRD\LeaveController;

/* ================== FINANCE ================== */
use App\Http\Controllers\Finance\PayrollController;
use App\Http\Controllers\Finance\SlipGajiController;
use App\Http\Controllers\Finance\DashboardController as FinanceDashboardController;

/* ================== KARYAWAN ================== */
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboard;
use App\Http\Controllers\Karyawan\AttendanceController as KaryawanAttendance;
use App\Http\Controllers\Karyawan\SlipGajiController as KaryawanSlipGaji;
use App\Http\Controllers\Karyawan\PasswordController as KaryawanPassword;
use App\Http\Controllers\Karyawan\ProfileController as KaryawanProfileController;
use App\Http\Controllers\Karyawan\LeaveRequestController;

/* ================== PRESENSI ================== */
use App\Http\Controllers\AttendanceController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Audit log
        Route::get('/audit-log', [AuditLogController::class, 'index'])
        ->name('audit');

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class,'index'])
            ->name('dashboard');

        // User Management
        Route::get('/users', [UserController::class, 'index'])
            ->name('users');

        Route::post('/users/{id}/toggle', [UserController::class, 'toggleStatus'])
            ->name('users.toggle');

        // Approval Karyawan
        Route::get('/employees', [EmployeeApprovalController::class, 'index'])
            ->name('employees');

        Route::post('/employees/{id}/approve', [EmployeeApprovalController::class, 'approve'])
            ->name('employees.approve');

        // Approval Payroll
        Route::get('/payroll', [PayrollApprovalController::class, 'index'])
            ->name('payroll');

        Route::post('/payroll/{id}/approve', [PayrollApprovalController::class, 'approve'])
            ->name('payroll.approve');

        Route::post('/payroll/{id}/reject', [PayrollApprovalController::class, 'reject'])
            ->name('payroll.reject');

        // Salary setting
        Route::get('/salary-settings', [SalarySettingController::class, 'index'])
            ->name('salary.settings');

        Route::post('/salary-settings', [SalarySettingController::class, 'store'])
            ->name('salary.settings.store');
});

/*
|--------------------------------------------------------------------------
| HRD
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:hrd'])
    ->prefix('hrd')
    ->name('hrd.')
    ->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Employee
    Route::get('/employees', [EmployeeController::class, 'index'])
        ->name('employees.index');

    Route::get('/employees/create', [EmployeeController::class, 'create'])
        ->name('employees.create');

    Route::post('/employees', [EmployeeController::class, 'store'])
        ->name('employees.store');

    // Attendance
    Route::get('/attendance', [AttendanceReportController::class, 'index'])
        ->name('attendance.index');

    Route::get('/attendance/monthly', [AttendanceReportController::class, 'monthly'])
        ->name('attendance.monthly');

    Route::get('/attendance/export/pdf', [AttendanceReportController::class, 'exportPdf'])
        ->name('attendance.export.pdf');

    Route::delete('/rfid/{id}', [RfidCardController::class, 'destroy'])
    ->name('rfid.destroy');    

    // RFID
    Route::get('/rfid', [RfidCardController::class, 'index'])
        ->name('rfid.index');

    Route::get('/rfid/create', [RfidCardController::class, 'create'])
        ->name('rfid.create');

    Route::post('/rfid', [RfidCardController::class, 'store'])
        ->name('rfid.store');

    // Cuti
    Route::get('/cuti', [LeaveController::class, 'index'])
    ->name('cuti.index');

    Route::post('/cuti/{id}/approve', [LeaveController::class, 'approve'])
    ->name('cuti.approve');

    Route::post('/cuti/{id}/reject', [LeaveController::class, 'reject'])
    ->name('cuti.reject');
});

/*
|--------------------------------------------------------------------------
| FINANCE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:finance'])
    ->prefix('finance')
    ->name('finance.')   // <- WAJIB ADA
    ->group(function () {

        Route::get('/dashboard', [FinanceDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/payroll', [PayrollController::class, 'index'])
            ->name('payroll.index');

        Route::post('/payroll/generate', [PayrollController::class, 'generate'])
            ->name('payroll.generate');

        Route::get('/payroll/history', [PayrollController::class, 'history'])
            ->name('payroll.history');

        Route::get('/payroll/{id}/download', [PayrollController::class, 'downloadSlip'])
            ->name('payroll.download');
});

/*
|--------------------------------------------------------------------------
| KARYAWAN  (⚠️ PALING PENTING)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:karyawan'])
    ->prefix('karyawan')
    ->group(function () {

        Route::get('/dashboard', [KaryawanDashboard::class, 'index']);

        Route::get('/attendance', [KaryawanAttendance::class, 'index']);

        // ✅ SLIP GAJI KARYAWAN (FINAL)
        Route::get('/slip-gaji', [KaryawanSlipGaji::class, 'index']);
        Route::get('/slip-gaji/{id}/pdf', [KaryawanSlipGaji::class, 'download']);

        Route::get('/password', [KaryawanPassword::class, 'edit']);
        Route::post('/password', [KaryawanPassword::class, 'update']);
    });


    Route::middleware(['auth','role:karyawan'])
    ->prefix('karyawan')
    ->name('karyawan.')
    ->group(function () {

        Route::get('/cuti', [LeaveRequestController::class, 'index'])
            ->name('cuti.index');

        Route::get('/cuti/create', [LeaveRequestController::class, 'create'])
            ->name('cuti.create');

        Route::post('/cuti', [LeaveRequestController::class, 'store'])
            ->name('cuti.store');
    });

/*
|--------------------------------------------------------------------------
| RFID Scan (PUBLIC)
|--------------------------------------------------------------------------
*/

Route::get('/rfid/scan', [AttendanceController::class, 'scanPage'])
    ->name('rfid.scan.page');

Route::post('/rfid/scan', [AttendanceController::class, 'scanProcess'])
    ->name('rfid.scan.process');

/*
|--------------------------------------------------------------------------
| Profile Global
|--------------------------------------------------------------------------
*/
    Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'show'])
        ->name('profile.show');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password');

    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])
        ->name('profile.avatar');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});
/*
|--------------------------------------------------------------------------
| AUTH (BREEZE)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
