<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Operational\Vendor;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorLimit extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    // declare table name
    protected $table = 'vendor_limits';

    // this field must type date yyyy-mm-dd hh:mm:ss
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'amount_limit',
        'created_by',
        'updated_by',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'amount_limit', 'created_by', 'updated_by'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn (string $eventName) => auth()->user()->name . " {$eventName} sales")
            ->useLogName('Vendor Limit log');
    }

    // 1 limit bisa dimiliki banyak vendor
    public function vendors()
    {
        return $this->hasMany(Vendor::class, 'id', 'vendor_limit_id',);
    }
}
