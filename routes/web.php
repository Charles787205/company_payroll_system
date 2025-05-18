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
use App\Http\Controllers\EmployeeViewController;
use App\Http\Controllers\PayrollPdfController;



Route::post('first-time-user-registration', [EmployeeController::class, 'registerFirstUserAsAdmin'])->name('first-time-user.registration');
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        if (strtolower(Auth::user()->employee->position->title) == 'admin') {
            return redirect()->route('dashboard'); // Redirect admins to the dashboard
        }
        return redirect()->route('employee-view.index'); // Redirect non-admins to the employee view
    })->name('home');

    Route::middleware([CheckUserPosition::class])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('employees', EmployeeController::class);
        Route::resource('positions', PositionController::class);
        Route::resource('attendance', AttendanceController::class);
        Route::resource('payrolls', PayrollAdminController::class);
        Route::get('/payrolls/{payroll}/attendances', [PayrollAdminController::class, 'showAttendances'])->name('payroll.attendances');
        Route::post('/payrolls/{payroll}/update-status', [PayrollAdminController::class, 'updatePayrollStatus'])->name('payroll.update-status');
        Route::resource('loans_and_deductions', LoansAndDeductionsController::class);
    });
    Route::get('/employee-view', [EmployeeViewController::class, 'index'])->name('employee-view.index');
    Route::get("/employee-view/payrolls", [EmployeeViewController::class, 'showPayroll'])->name('employee-view.payroll');
    Route::get("/employee-view/loans_and_deductions", [EmployeeViewController::class, 'showLoansAndDeductions'])->name('employee-view.loans-and-deductions');
    Route::post('/employee-view/store_attendances', [EmployeeViewController::class, 'storeAttendances'])->name('employee-view.store-attendances');
    Route::get('/employee-view/{payroll}/attendances', [EmployeeViewController::class, 'showAttendances'])->name('employee-view.show-attendances');
    Route::get('/employee-view/{payroll}/deductions', [EmployeeViewController::class, 'showDeductions'])->name('employee-view.show-deductions');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/payrolls/{payroll}/set-paid', [PayrollAdminController::class, 'setPayrollPaid'])->name('payrolls.setPaid');
    Route::get('/payrolls/{payroll}/download-pdf', [PayrollPdfController::class, 'downloadPdf'])->name('payroll.download-pdf');
});


require __DIR__.'/auth.php';
