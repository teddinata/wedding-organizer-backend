<?php

namespace App\Models\Operational;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'attendances';

    protected $fillable = [
        'employee_id',
        'date',
        'clock_in',
        'clock_in_photo',
        'clock_in_location',
        'clock_in_address',
        'clock_out',
        'clock_out_photo',
        'clock_out_location',
        'clock_out_address',
        'status',
        'platform',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // logs
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['employee_id',
                    'date',
                    'clock_in',
                    'clock_in_photo',
                    'clock_in_location',
                    'clock_in_address',
                    'clock_out',
                    'clock_out_photo',
                    'clock_out_location',
                    'clock_out_address',
                    'status',
                    'platform',
                    'created_by',
                    'updated_by',
                    'deleted_by',
                ]);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

}
