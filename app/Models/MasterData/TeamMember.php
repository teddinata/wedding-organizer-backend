<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TeamMember extends Model
{
    use HasFactory;
    // use SoftDeletes;
    use LogsActivity;

    protected $table = 'team_members';

    protected $fillable = [
        'team_id',
        'employee_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // logs
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['team_id', 'employee_id', 'created_by', 'updated_by', 'deleted_by']);
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    // relasi dengan employee
    public function employee()
    {
        return $this->belongsTo(Employee::class,  'employee_id', 'id',);
    }
}
