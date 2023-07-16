<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'logo',
        'code',
        'name',
        'contact_person',
        'contact_number',
        'website',
        'instagram',
        'address',
        'city',
        'point',
        'vendor_limit_id',
        'vendor_grade_id',
        'membership_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // logs activity
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'code', 'contact_person', 'contact_number', 'website', 'instagram', 'address', 'city', 'point','vendor_limit_id', 'vendor_grade_id', 'membership_id', 'created_by', 'updated_by', 'deleted_by']);
    }

    // 1 vendor memiliki limit
    public function vendor_limit()
    {
        return $this->belongsTo(VendorLimit::class, 'vendor_limit_id', 'id');
    }

    // 1 vendor memiliki grade
    public function vendor_grade()
    {
        return $this->belongsTo(VendorGrade::class, 'vendor_grade_id', 'id');
    }

}
