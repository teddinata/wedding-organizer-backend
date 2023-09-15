<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'levels';

    protected $fillable = [
        'icon',
        'name',
        'from',
        'until',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // logs
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['icon', 'name', 'from', 'until', 'created_by', 'updated_by', 'deleted_by']);
    }

    // 1 level memiliki banyak employee
    public function employee()
    {
        return $this->hasMany(Employee::class, 'level_id', 'id');
    }
}
