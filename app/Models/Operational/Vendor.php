<?php

namespace App\Models\Operational;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\MasterData\VendorLimit;
use App\Models\MasterData\VendorGrade;
use App\Models\MasterData\Membership;

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
        'cover_photo',
        'code',
        'name',
        'contact_person',
        'person_level',
        'contact_number',
        'website',
        'instagram',
        'address',
        'city',
        'point',
        'email',
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
            ->logOnly(['name', 'code', 'logo', 'cover_photo', 'person_level', 'contact_person', 'contact_number', 'website', 'instagram', 'address', 'city', 'point','vendor_limit_id', 'vendor_grade_id', 'membership_id', 'created_by', 'updated_by', 'deleted_by']);
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

    // 1 vendor memiliki membership
    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id', 'id');
    }
}
