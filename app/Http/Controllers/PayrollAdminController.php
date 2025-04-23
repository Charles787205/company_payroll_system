<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use App\Models\LoanOrDeduction;
use Illuminate\Http\Request;

class PayrollAdminController extends Controller
{
    // List all payrolls
    public function index()
    {
        $payrolls = Payroll::with('employee')
            ->orderByRaw("FIELD(status, 'pending') DESC") // Ensure 'pending' is first
            ->orderByRaw("CASE WHEN status = 'pending' THEN created_at END ASC") // Oldest pending first
            ->orderBy('updated_at', 'DESC') // Newest updated for non-pending
            ->get();

        $employees = Employee::with(['loansAndDeductions' => function ($query) {
            $query->whereDoesntHave('employeeDeductions', function ($subQuery) {
                $subQuery->where('date', '>=', now()->startOfMonth()) // Check for deductions in the current month
                         ->where('date', '<=', now()->endOfMonth());
            });
        }])->get();

        return view('payrolls.index', compact('payrolls', 'employees'));
    }

    // Show form to create a new payroll
    public function create()
    {
        $employees = Employee::all();
        $payrolls = Payroll::all()->with('employee');
        $payrolls->load('employee');
        return view('payrolls.create', compact('payrolls'));
    }

    // Store a new payroll
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'amount' => 'required|numeric|min:0',
        ]);

        Payroll::create($validatedData);

        return redirect()->route('payrolls.index')->with('success', 'Payroll record created successfully.');
    }

    // Show details of a specific payroll
    public function show(Payroll $payroll)
    {
        $deductions = LoanOrDeduction::where('employee_id', $payroll->employee_id)->get();
        return view('payrolls.show', compact('payroll', 'deductions'));
    }

    // Show form to edit a payroll
    public function edit(Payroll $payroll)
    {
        $employees = Employee::all();
        return view('payrolls.edit', compact('payroll', 'employees'));
    }

    // Update a payroll
    public function update(Request $request, Payroll $payroll)
    {   
        
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'amount' => 'required|numeric|min:0',
        ]);

        $payroll->update($validatedData);

        return redirect()->route('payrolls.index')->with('success', 'Payroll record updated successfully.');
    }
    public function updatePayrollStatus(Request $request, Payroll $payroll){
        if($payroll->status != Payroll::STATUS_PENDING){
            return redirect()->route('payrolls.index')->with('error', 'Cannot update a paid payroll record.');
        }
        $validatedData = $request->validate([
            'status' => 'required|in:pending,declined,approved,paid',
        ]);

        $payroll->update($validatedData);

        return redirect()->route('payrolls.index')->with('success', 'Payroll status updated successfully.');
        
    }
    // Delete a payroll
    public function destroy(Payroll $payroll)
    {
        $payroll->delete();

        return redirect()->route('payrolls.index')->with('success', 'Payroll record deleted successfully.');
    }

    // Show attendances for a specific payroll
    public function showAttendances(Payroll $payroll)
    {
        $attendances = $payroll->attendances()->with('employee')->get();

        return response()->json([
            'attendances' => $attendances,
        ]);
    }
}
