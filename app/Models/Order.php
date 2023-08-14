<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'orders';

    protected $fillable = [
        'sales_id',
        'employee_id',
        'vendor_id',
        'order_number',
        'order_seq',
        'date',
        'loading_date',
        'loading_time',
        'event_date',
        'event_time',
        'venue',
        'room',
        'coordinator_schedule',
        'subtotal',
        'discount',
        'total',
        'notes',
        // is checklist tree
        'is_checklist_tree',
        'is_checklist_melamin',
        'is_checklist_lighting',
        'is_checklist_gazebo',
        'points',
        'extra_points',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // logs
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['sales_id', 'employee_id', 'vendor_id', 'order_number', 'order_seq', 'date', 'loading_date', 'loading_time', 'event_date', 'event_time', 'venue', 'room', 'coordinator_schedule', 'subtotal', 'discount', 'total', 'notes', 'created_by', 'updated_by', 'deleted_by']);
    }

    // relasi dengan sales
    public function sales()
    {
        return $this->belongsTo(Sales::class, 'sales_id', 'id');
    }

    // relasi dengan employee
    public function employee()
    {
        return $this->belongsToMany(Employee::class, 'employee_id', 'id');
    }

    // relasi dengan vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }

    // relasi dengan order additional services
    public function order_additional_services()
    {
        return $this->hasMany(OrderAdditionalService::class, 'order_id', 'id');
    }

    // relasi dengan order history
    public function order_histories()
    {
        return $this->hasMany(OrderHistory::class, 'order_id', 'id');
    }

    // relasi dengan order product
    public function order_products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }



}
