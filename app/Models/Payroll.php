<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'from_date',
        'to_date',
        'amount',
        'status', // Ensure status is fillable
        'approved',
    ];

    // Define the possible status values
    const STATUS_PENDING = 'pending';
    const STATUS_DECLINED = 'declined';
    const STATUS_APPROVED = 'approved';
    const STATUS_PAID = 'paid';
    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_DECLINED,
            self::STATUS_APPROVED,
            self::STATUS_PAID,
        ];  
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    
}
