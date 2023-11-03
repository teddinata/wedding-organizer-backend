<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreatedUpdatedBy;

class Allowance extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    use CreatedUpdatedBy;

    // declare fillable fields
    protected $fillable = [
        'department_id',
        'name',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // logs
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'created_by', 'updated_by', 'deleted_by'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn (string $eventName) => auth()->user()->name . " {$eventName} allowance")
            ->useLogName('Master Allowance log');
    }

    // relasi dengan department
    // public function departments()
    // {
    //     return $this->belongsToMany(Department::class, 'department_allowances', 'department_id', 'allowance_id');
    // }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_allowances', 'allowance_id', 'department_id');
    }


    // relasi dengan employee allowance
    public function employee_allowance()
    {
        return $this->hasMany(EmployeeAllowance::class, 'allowance_id', 'id');
    }
}
