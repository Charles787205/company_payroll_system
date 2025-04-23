<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoansAndDeductions extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'employee_id',
        'name', // Add the 'name' column
        'amount',
        'remaining_balance',
        'frequency',
    ];

    // Define the possible types
    const TYPE_LOAN = 'loan';
    const TYPE_DEDUCTION = 'deduction';

    // Define the possible frequencies
    const FREQUENCY_MONTHLY = 'monthly';
    const FREQUENCY_BI_WEEKLY = 'bi-weekly';

    public static function getTypes()
    {
        return [
            self::TYPE_LOAN,
            self::TYPE_DEDUCTION,
        ];
    }

    public static function getFrequencies()
    {
        return [
            self::FREQUENCY_MONTHLY,
            self::FREQUENCY_BI_WEEKLY,
        ];
    }

    // Relationship with Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function employeeDeductions()
    {
        return $this->hasMany(EmployeeDeduction::class);
    }
}