<?php

namespace App\Models\Operational;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamLoan extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'team_loans';

    protected $fillable = [
        'team_id',
        'loan_number',
        'loan_date',
        'description',
        'loan_amount',
        'loan_status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // logs
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'team_id',
                'loan_number',
                'loan_date',
                'description',
                'loan_amount',
                'loan_status',
                'created_by',
                'updated_by',
                'deleted_by',
            ]);
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
