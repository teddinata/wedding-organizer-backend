<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorGrade extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'name',
        'description',
        'created_by',
        'updated_by',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'description', 'created_by', 'updated_by']);
    }

    // 1 grade bisa dimiliki banyak vendor
    public function vendors()
    {
        return $this->hasMany(Vendor::class,   'id', 'vendor_grade_id',);
    }

}
