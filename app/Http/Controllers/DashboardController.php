<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the total number of employees
        $totalEmployees = Employee::count();

        // Get the total number of approved payrolls
        $approvedPayrolls = Payroll::where('status', 'approved')->count();

        // Get the total number of pending payrolls
        $pendingPayrolls = Payroll::where('status', 'pending')->count();

        // Pass the data to the dashboard view
        return view('dashboard.index', compact('totalEmployees', 'approvedPayrolls', 'pendingPayrolls'));
    }
}
