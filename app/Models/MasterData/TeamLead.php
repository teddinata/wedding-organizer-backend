<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamLead extends Model
{
    use HasFactory;

    protected $table = 'team_leads';

    protected $fillable = [
        'team_id',
        'employee_id',
        'user_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
