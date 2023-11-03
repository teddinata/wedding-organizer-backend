<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class DepartmentAllowance extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    // this field must type date yyyy-mm-dd hh:mm:ss
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // declare fillable fields
    protected $fillable = [
        'department_id',
        'allowance_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // logs
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['department_id', 'allowance_id', 'created_by', 'updated_by', 'deleted_by'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn (string $eventName) => auth()->user()->name . " {$eventName} departement allowance")
            ->useLogName('Department Allowance log');
    }

    // pivot table to department table and allowance table (many to many)
    // public function department()
    // {
    //     return $this->belongsToMany(Department::class, 'department_allowances', 'department_id', 'id');
    // }

    // public function allowance()
    // {
    //     return $this->belongsToMany(Allowance::class, 'department_allowances', 'allowance_id', 'id');
    // }

    public function allowance()
    {
        return $this->belongsTo(Allowance::class, 'allowance_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

}
