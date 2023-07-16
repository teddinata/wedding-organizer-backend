<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorLimit extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'name',
        'amount_limit',
        'created_by',
        'updated_by',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'amount_limit', 'created_by', 'updated_by']);
    }

    // 1 limit bisa dimiliki banyak vendor
    public function vendors()
    {
        return $this->hasMany(Vendor::class,'id', 'vendor_limit_id',  );
    }
}
