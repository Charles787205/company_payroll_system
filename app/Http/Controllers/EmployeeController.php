<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use App\Models\Role; // Assuming you have a Role model for roles
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;

class EmployeeController extends Controller
{
    // List all employees
    public function index()
    {
        $employees = Employee::all();
       
        return view('employees.index', compact('employees') );
    }

    // Show form to add a new employee
    public function create()
    {
        $positions = Position::all();
        return view('employees.create',compact('positions'));
    }

    // Store a new employee
    public function store(Request $request)
    {   
        $userValidatedData = $request->validate([
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);
        $validatedData = $request->validate([
            'birthdate' => 'required|date',
            'age' => 'nullable|integer|min:0',
            'first_name' => 'required|string|max:255',
            'position_id' => 'required|exists:App\Models\Position,id',
            'address' => 'nullable|string|max:255',
            'salary' => 'required|numeric',
            'hire_date' => 'required|date',
            'sss_number' => 'nullable|string|max:15',
            'pagibig_number' => 'nullable|string|max:15',
            'philhealth_number' => 'nullable|string|max:20',
        ]);

  
            try {
                DB::beginTransaction();

                $user = User::create([
                    'first_name' => $userValidatedData['first_name'], // Replace spaces with underscores and trim
                    'middle_name' => $userValidatedData['middle_name'] ?? null, // Handle nullable middle name
                    'last_name' => $userValidatedData['last_name'],
                    'email' => $userValidatedData['email'],
                    'password' => bcrypt(preg_replace('/\s+/', '_', trim($userValidatedData['first_name'])) . $validatedData['age']), // Combine modified first name and age for password
                ]);

                Employee::create([
                    'user_id' => $user->id,
                    'position_id' => $validatedData['position_id'],
                    'salary' => $validatedData['salary'],
                    'hire_date' => $validatedData['hire_date'],
                    'birthdate' => $validatedData['birthdate'],
                    'age' => $validatedData['age'],
                    'address' => $validatedData['address'],
                    'sss_number' => $validatedData['sss_number'],
                    'pagibig_number' => $validatedData['pagibig_number'],
                    'philhealth_number' => $validatedData['philhealth_number'],
                ]);

                DB::commit();
        } catch (Exception $e) {
                DB::rollBack();
                Log::error('Failed to create employee: ' . $e->getMessage());
                return redirect()->route('employees.create')->withErrors($e->getMessage() . ' ' . $validatedData['position_id']);
        }
        return redirect()->route('employees.index')->with('success', 'Employee added successfully.');
    }

    // Show details of a specific employee
    public function show($id)
    {
        // Fetch the employee with their loans and deductions
        $employee = Employee::with('user', 'position', 'loansAndDeductions')->findOrFail($id);

        return view('employees.show', compact('employee'));
    }

    // Register the first user as admin
    public function registerFirstUserAsAdmin(Request $request)
    {
        // Check if there are any users in the database
        if (User::count() > 0) {
            return redirect()->route('login')->withErrors('Admin registration is not allowed. Users already exist.');
        }

        $position = Position::where('title', 'Admin')->first();
        if ($position === null) {
            // Create the position if it doesn't exist
            $position = Position::create([
                'title' => 'Admin',
                'description' => 'Administrator role with full access',
                'base_salary' => 0
            ]);
        }

        // Validate the request data
        $userValidatedData = $request->validate([
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);
        $validatedData = $request->validate([
            'birthdate' => 'required|date',
            'age' => 'nullable|integer|min:0',
            'address' => 'nullable|string|max:255',
            'salary' => 'required|numeric',
            'hire_date' => 'required|date',
            'sss_number' => 'nullable|string|max:15',
            'pagibig_number' => 'nullable|string|max:15',
            'philhealth_number' => 'nullable|string|max:20',
        ]);

        if ($userValidatedData['password'] !== $userValidatedData['password_confirmation']) {
            return redirect()->back()->withErrors('Password and confirmation do not match.');
        }

        try {
            DB::beginTransaction();

            // Create the user
            $user = User::create([
                'first_name' => $userValidatedData['first_name'], // Corrected to use $userValidatedData
                'middle_name' => $userValidatedData['middle_name'] ?? null, // Handle nullable middle name
                'last_name' => $userValidatedData['last_name'], // Corrected to use $userValidatedData
                'email' => $userValidatedData['email'], // Corrected to use $userValidatedData
                'password' => Hash::make($userValidatedData['password']), // Corrected to use $userValidatedData
            ]);

            // Create the employee
            Employee::create([
                'user_id' => $user->id,
                'position_id' => $position->id,
                'salary' => $validatedData['salary'],
                'hire_date' => $validatedData['hire_date'],
                'birthdate' => $validatedData['birthdate'],
                'age' => $validatedData['age'],
                'address' => $validatedData['address'],
                'sss_number' => $validatedData['sss_number'],
                'pagibig_number' => $validatedData['pagibig_number'],
                'philhealth_number' => $validatedData['philhealth_number'],
            ]);

            

            DB::commit();

            return redirect()->route('login')->with('success', 'Admin account created successfully. You can now log in.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to register admin: ' . $e->getMessage());
            return redirect()->back()->withErrors('Failed to register admin: ' . $e->getMessage());
        }
    }
}
