<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\LoanOrDeduction;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

class LoanOrDeductionController extends Controller
{
    // List all loans and deductions
    public function index()
    {
        $loansAndDeductions = LoanOrDeduction::with('employee')->get();
        return view('loans_and_deductions.index', compact('loansAndDeductions'));
    }

    // Show form to create a new loan or deduction
    public function create()
    {
        $employees = Employee::all();
        return view('loans_and_deductions.create', compact('employees'));
    }

    // Store a new loan or deduction
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required|in:loan,deduction',
            'employee_id' => 'required|exists:employees,id',
            'amount' => 'required|numeric|min:0',
            'remaining_balance' => 'nullable|numeric|min:0',
            'frequency' => 'required|in:monthly,bi-weekly',
        ]);

        LoanOrDeduction::create($validatedData);

        return redirect()->route('loans_and_deductions.index')->with('success', 'Loan or deduction created successfully.');
    }

    // Show form to edit a loan or deduction
    public function edit(LoanOrDeduction $loanOrDeduction)
    {
        $employees = Employee::all();
        return view('loans_and_deductions.edit', compact('loanOrDeduction', 'employees'));
    }

    // Update a loan or deduction
    public function update(Request $request, LoanOrDeduction $loanOrDeduction)
    {
        $validatedData = $request->validate([
            'type' => 'required|in:loan,deduction',
            'employee_id' => 'required|exists:employees,id',
            'amount' => 'required|numeric|min:0',
            'remaining_balance' => 'nullable|numeric|min:0',
            'frequency' => 'required|in:monthly,bi-weekly',
        ]);

        $loanOrDeduction->update($validatedData);

        return redirect()->route('loans_and_deductions.index')->with('success', 'Loan or deduction updated successfully.');
    }

    // Delete a loan or deduction
    public function destroy(LoanOrDeduction $loanOrDeduction)
    {
        $loanOrDeduction->delete();

        return redirect()->route('loans_and_deductions.index')->with('success', 'Loan or deduction deleted successfully.');
    }
}
