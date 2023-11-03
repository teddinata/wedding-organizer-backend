<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreatedUpdatedBy;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    use CreatedUpdatedBy;

    // this field must type date yyyy-mm-dd hh:mm:ss
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // declare fillable fields
    protected $fillable = [
        'name',
        'payroll_type',
        'is_has_schedule',
        'clock_in',
        'clock_out',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // logs
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'payroll_type', 'is_has_schedule', 'clock_in', 'clock_out', 'created_by', 'updated_by', 'deleted_by'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn (string $eventName) => auth()->user()->name . " {$eventName} departement")
            ->useLogName('Master Department log');
    }

    // public function allowance()
    // {
    //     return $this->hasMany(Allowance::class, 'department_allowances', 'department_id', 'allowance_id');
    // }

    public function allowances()
    {
        return $this->belongsToMany(Allowance::class, 'department_allowances', 'department_id', 'allowance_id');
    }


    // relation department allowance
    public function department_allowance()
    {
        return $this->hasMany(DepartmentAllowance::class, 'department_id');
    }

    // 1 department memiliki banyak employee
    public function employee()
    {
        return $this->hasMany(Employee::class, 'department_id', 'id');
    }

    // 1 department memiliki banyak position
    public function position()
    {
        return $this->hasMany(Position::class, 'department_id', 'id');
    }
}
