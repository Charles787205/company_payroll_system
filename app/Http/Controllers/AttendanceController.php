<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // List all attendance records
    public function index()
    {
        $attendances = Attendance::with('employee')->get();
        return view('attendance.index', compact('attendances'));
    }

    // Show form to create a new attendance record
    public function create()
    {
        $employees = Employee::all();
        return view('attendance.create', compact('employees'));
    }

    // Store a new attendance record
    public function store(Request $request)
    {
        try {
            // Start a database transaction
            DB::beginTransaction();

            $validatedData = $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'dates' => 'required|array', // Ensure dates is an array
                'time_in' => 'nullable|array', // Ensure time_in is an array
                'time_out' => 'nullable|array', // Ensure time_out is an array
                'time_in.*' => 'nullable|date_format:H:i', // Validate each time_in
                'time_out.*' => 'nullable|date_format:H:i|after:time_in.*', // Validate each time_out
            ]);

            $employeeId = $validatedData['employee_id'];
            $dates = $validatedData['dates'];
            $timeIn = $validatedData['time_in'];
            $timeOut = $validatedData['time_out'];

            // Determine the payroll period based on the first date
            $payrollPeriod = $this->getPayrollPeriod($dates[0]);

            // Check if a payroll already exists for the employee and the payroll period
            $payroll = Payroll::where('employee_id', $employeeId)
                ->where('from_date', $payrollPeriod['from_date'])
                ->where('to_date', $payrollPeriod['to_date'])
                ->first();
            
            
            // If no payroll exists, create a new one
            
            $payroll = Payroll::create([
                'employee_id' => $employeeId,
                'from_date' => $payrollPeriod['from_date'],
                'to_date' => $payrollPeriod['to_date'],
                'amount' => 0, // Set initial amount to 0
                'approved' => false, // Default to not approved
            ]);
            

            // Get the employee's hourly rate (assuming it's stored in the Employee model)
            $employee = Employee::findOrFail($employeeId);
            $hourlyRate = $employee->salary / 8; // Salary divided by 8 hours
            $salary = 0;
            // Loop through the dates and create attendance records
            foreach ($dates as $date) {
                $timeInValue = $timeIn[$date] ?? null;
                $timeOutValue = $timeOut[$date] ?? null;

                // Calculate rendered hours if both time_in and time_out are provided
                $renderedHours = 0;
                if ($timeInValue && $timeOutValue) {
                    $timeInCarbon = \Carbon\Carbon::createFromFormat('H:i', $timeInValue);
                    $timeOutCarbon = \Carbon\Carbon::createFromFormat('H:i', $timeOutValue);

                    $hoursWorked = $timeInCarbon->diffInHours($timeOutCarbon);

                    if ($hoursWorked > 7) {
                        $renderedHours = max(0, $hoursWorked - 1); // Subtract 1 hour for lunch break
                    } else {
                        $renderedHours = max(0, $hoursWorked);
                    }
                    
                }
                
                

                // Calculate the amount for this attendance
                $attendanceAmount = $renderedHours * $hourlyRate;

                // Add the attendance amount to the salary total
                $salary += $attendanceAmount;

                // Create the attendance record
                Attendance::create([
                    'employee_id' => $employeeId,
                    'date' => $date,
                    'time_in' => $timeInValue,
                    'time_out' => $timeOutValue,
                    'payroll_id' => $payroll->id, // Link to the payroll
                ]);
            }   
            // Update the payroll amount
            $payroll->amount = $salary;

            // Save the updated payroll amount
            $payroll->save();

            // Commit the transaction
            DB::commit();

            return redirect()->route('attendance.index')->with('success', 'Attendance records added successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();

            // Log the error for debugging
            \Log::error('Error storing attendance: ' . $e->getMessage());

            // Pass only the exception message to the session
            return redirect()->route('attendance.index')->with('error', 'Failed to add attendance records. Please try again.');
        }
    }

    // Show a specific attendance record
    public function show(Attendance $attendance)
    {
        return view('attendance.show', compact('attendance'));
    }

    // Show form to edit an attendance record
    public function edit(Attendance $attendance)
    {
        $employees = Employee::all();
        return view('attendance.edit', compact('attendance', 'employees'));
    }

    // Update an attendance record
    public function update(Request $request, Attendance $attendance)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'time_in' => 'nullable|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i|after:time_in',
        ]);

        $attendance->update($validatedData);

        return redirect()->route('attendance.index')->with('success', 'Attendance record updated successfully.');
    }

    // Delete an attendance record
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('attendance.index')->with('success', 'Attendance record deleted successfully.');
    }

    /**
     * Determine the payroll period based on the given date.
     */
    private function getPayrollPeriod($date)
    {
        $carbonDate = \Carbon\Carbon::parse($date);

        if ($carbonDate->day <= 15) {
            // First payroll period: 1–15
            return [
                'from_date' => $carbonDate->startOfMonth()->format('Y-m-d'),
                'to_date' => $carbonDate->startOfMonth()->addDays(14)->format('Y-m-d'),
            ];
        } else {
            // Second payroll period: 16–end of the month
            return [
                'from_date' => $carbonDate->startOfMonth()->addDays(15)->format('Y-m-d'),
                'to_date' => $carbonDate->endOfMonth()->format('Y-m-d'),
            ];
        }
    }
}
