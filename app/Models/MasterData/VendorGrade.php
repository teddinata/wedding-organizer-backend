<?php

namespace App\Models\MasterData;

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

    // declare table name
    protected $table = 'vendor_grades';

    // this field must type date yyyy-mm-dd hh:mm:ss
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // declare fillable fields
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
        return $this->hasMany(Vendor::class, 'id', 'vendor_grade_id',);
    }
}
