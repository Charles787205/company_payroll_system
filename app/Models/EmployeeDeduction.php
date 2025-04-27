<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDeduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'loans_and_deductions_id',
        'deduction_amount',
        'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function loansOrDeductions()
    {
        return $this->belongsTo(LoanOrDeduction::class, 'loans_and_deductions_id');
    }
}