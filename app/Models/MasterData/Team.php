<?php

namespace App\Models\MasterData;

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

    // declare table name
    protected $table = 'teams';

    // this field must type date yyyy-mm-dd hh:mm:ss
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // declare fillable fields

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
            ->logOnly([
                'name',
                'created_by',
                'updated_by',
                'deleted_by',
            ]);
    }

    // one pic can be assigned to multiple team
    public function lead()
    {
        return $this->belongsToMany(User::class, 'team_lead', 'team_id', 'user_id')->withTimestamps();
    }

    // one team has many member
    public function member()
    {
        return $this->belongsToMany(Employee::class, 'team_members', 'team_id', 'employee_id')->withTimestamps();
    }

    // one team can have more than 1 loan
    public function team_loan()
    {
        return $this->hasMany(TeamLoan::class, 'team_id');
    }
}
