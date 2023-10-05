<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'positions';

    // this field must type date yyyy-mm-dd hh:mm:ss
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'department_id',
        'career_level_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // logs
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'career_level_id', 'created_by', 'updated_by', 'deleted_by'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn (string $eventName) => auth()->user()->name . " {$eventName} position")
            ->useLogName('Master Position log');
    }

    // 1 position memiliki banyak employee
    public function employee()
    {
        return $this->hasMany(Employee::class, 'position_id', 'id');
    }

    // relasi dengan department
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    // relasi dengan career level
    public function career_level()
    {
        return $this->belongsTo(CareerLevel::class, 'career_level_id', 'id');
    }
}
