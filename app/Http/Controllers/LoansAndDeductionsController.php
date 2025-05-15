<?php

namespace App\Http\Controllers;

use App\Models\LoansAndDeductions;
use App\Models\Employee;
use Illuminate\Http\Request;

class LoansAndDeductionsController extends Controller
{
    // List all loans and deductions
    public function index()
    {
        // Fetch employees with their loans and deductions count
        $employeesWithLoansAndDeductions = Employee::whereHas('loansAndDeductions')
            ->withCount('loansAndDeductions') // Count loans and deductions for each employee
            ->get();

        return view('loans_and_deductions.index', compact('employeesWithLoansAndDeductions'));
    }

    // Show form to create a new loan or deduction
    public function create()
    {
        $employees = Employee::all();
        $types = LoansAndDeductions::getTypes();
        $frequencies = LoansAndDeductions::getFrequencies();
        return view('loans_and_deductions.create', compact('employees', 'types', 'frequencies','name'));
    }

    // Store a new loan or deduction
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required|in:' . implode(',', LoansAndDeductions::getTypes()),
            'employee_id' => 'required|exists:employees,id',
            'amount' => 'required|numeric|min:0',
            'remaining_balance' => 'nullable|numeric|min:0',
            'frequency' => 'required|in:' . implode(',', LoansAndDeductions::getFrequencies()),
            'name' => 'required|string|max:255',
        ]);

        LoansAndDeductions::create($validatedData);

        return redirect()->route('loans_and_deductions.index')->with('success', 'Loan or deduction created successfully.');
    }

    // Show form to edit a loan or deduction
    public function edit($id)
    {
        $loansAndDeduction = LoansAndDeductions::findOrFail($id);
        $employees = Employee::all();
        $types = LoansAndDeductions::getTypes();
        $frequencies = LoansAndDeductions::getFrequencies();
        return view('loans_and_deductions.edit', compact('loansAndDeduction', 'employees', 'types', 'frequencies'));
    }

    // Update a loan or deduction
    public function update(Request $request, $id)
    {
        $loansAndDeduction = LoansAndDeductions::findOrFail($id);
        
        $validatedData = $request->validate([
            'type' => 'required|in:' . implode(',', LoansAndDeductions::getTypes()),
            'employee_id' => 'required|exists:employees,id',
            'amount' => 'required|numeric|min:0',
            'remaining_balance' => 'nullable|numeric|min:0',
            'frequency' => 'required|in:' . implode(',', LoansAndDeductions::getFrequencies()),
            'name' => 'required|string|max:255',
        ]);

        $loansAndDeduction->update($validatedData);

        return redirect()->route('employees.show', $loansAndDeduction->employee_id)->with('success', 'Loan or deduction updated successfully.');
    }

    // Delete a loan or deduction
    public function destroy($id)
    {
        $loansAndDeduction = LoansAndDeductions::findOrFail($id);
        $employeeId = $loansAndDeduction->employee_id;
        
        $loansAndDeduction->delete();

        return redirect()->route('employees.show', $employeeId)->with('success', 'Loan or deduction deleted successfully.');
    }
}