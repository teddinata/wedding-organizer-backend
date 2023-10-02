<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Allowance extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'allowances';

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
            ->logOnly(['department_id', 'name', 'description', 'created_by', 'updated_by', 'deleted_by'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn (string $eventName) => auth()->user()->name . " {$eventName} allowance")
            ->useLogName('Master Allowance log');
    }

    // relasi dengan department id
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    // relasi dengan employee allowance
    public function employee_allowance()
    {
        return $this->hasMany(EmployeeAllowance::class, 'allowance_id', 'id');
    }
}
