<?php

namespace App\Models\Operational;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'leads';

    protected $fillable = [
        'vendor_id',
        'date',
        'pic',
        'response',
        'code',
        'note',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // logs
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['vendor_id', 'date', 'pic', 'response', 'code', 'note', 'created_by', 'updated_by', 'deleted_by']);
    }

    // relasi dengan lead detail
    public function lead_detail()
    {
        return $this->hasMany(LeadDetail::class, 'lead_id', 'id');
    }

    // relasi dengan vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }
}
