<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'time_in',
        'time_out',
        'payroll_id',
    ];

    /**
     * Define the relationship with the Employee model.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Define the relationship with the Payroll model.
     */
    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }
}
