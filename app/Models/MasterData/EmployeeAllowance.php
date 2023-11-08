<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeAllowance extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'employee_allowances';

    protected $fillable = [
        'employee_id',
        'allowance_id',
        'amount',
        'effective_date',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
    kontol;

    // logs
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['employee_id', 'allowance_id', 'amount', 'effective_date', 'created_by', 'updated_by', 'deleted_by'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn (string $eventName) => auth()->user()->name . " {$eventName} employee allowance")
            ->useLogName('Employee Allowance log');
    }

    // relasi dengan employee
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
