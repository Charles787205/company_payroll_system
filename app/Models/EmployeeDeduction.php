<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDeduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'loan_or_deduction_id',
        'deduction_amount',
        'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function loanOrDeductions()
    {
        return $this->belongsTo(LoanOrDeduction::class, 'loan_or_deduction_id');
    }
}