<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'position_id',
        'salary',
        'hire_date',
        'birthdate', // Add Birthdate
        'age',       // Add Age
        'address',   // Add Address
        'sss_number',
        'pagibig_number',
        'philhealth_number',
    ];

    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }

    public function loansAndDeductions()
    {
        return $this->hasMany(LoansAndDeductions::class);
    }
    public function employeeDeductions(){
        return $this->hasMany(EmployeeDeduction::class);
    }

    
}