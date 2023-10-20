<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreatedUpdatedBy;

class Membership extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    use CreatedUpdatedBy;

    // this field must type date yyyy-mm-dd hh:mm:ss
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // declare fillable fields
    protected $fillable = [
        'name',
        'image',
        'from',
        'until',
        'point',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // get logs
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'image', 'from', 'until', 'point', 'created_by', 'updated_by', 'deleted_by'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn (string $eventName) => auth()->user()->name . " {$eventName} membership")
            ->useLogName('Vendor Membership log');
    }

    //  1 membership memiliki banyak member benefit
    public function member_benefit()
    {
        return $this->hasMany(MemberBenefit::class, 'membership_id', 'id');
    }

    // relasi dengan vendor
    public function vendor()
    {
        return $this->hasMany(Vendor::class, 'membership_id', 'id');
    }
}
