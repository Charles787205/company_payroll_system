<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PayrollAdminController;
use App\Http\Controllers\LoanOrDeductionController;
use App\Http\Controllers\LoansAndDeductionsController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserPosition;



Route::post('first-time-user-registration', [EmployeeController::class, 'registerFirstUserAsAdmin'])->name('first-time-user.registration');
Route::middleware(['auth'])->group(function () {
    
    Route::middleware([CheckUserPosition::class])->group(function () {
        Route::get('/', function () {
            return redirect()->route('dashboard');
        })->name('home');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('employees', EmployeeController::class);
        Route::resource('positions', PositionController::class);
        Route::resource('attendance', AttendanceController::class);
        Route::resource('payrolls', PayrollAdminController::class);
        Route::get('/payrolls/{payroll}/attendances', [PayrollAdminController::class, 'showAttendances'])->name('payroll.attendances');
        Route::post('/payrolls/{payroll}/update-status', [PayrollAdminController::class, 'updatePayrollStatus'])->name('payroll.update-status');
        Route::resource('loans_and_deductions', LoansAndDeductionsController::class);
    });
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

    

require __DIR__.'/auth.php';
