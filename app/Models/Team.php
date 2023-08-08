<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'teams';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // logs
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name',
                    'created_by',
                    'updated_by',
                    'deleted_by',
                ]);
    }

    public function lead()
    {
        return $this->belongsToMany(User::class, 'team_lead', 'team_id', 'user_id')->withTimestamps();
    }

    public function member()
    {
        return $this->belongsToMany(Employee::class, 'team_members', 'team_id', 'employee_id')->withTimestamps();
    }

    public function team_loan()
    {
        return $this->hasMany(TeamLoan::class, 'team_id');
    }
}
