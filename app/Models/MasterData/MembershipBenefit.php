<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembershipBenefit extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    // declare fillable fields
    protected $fillable = [
        'membership_id',
        'benefit_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // logs
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['membership_id', 'benefit_id', 'created_by', 'updated_by', 'deleted_by']);
    }

    // banyak membership benefit dimiliki 1 membership
    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id', 'id');
    }
}
