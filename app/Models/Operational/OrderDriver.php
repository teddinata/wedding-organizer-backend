<?php

namespace App\Models\Operational;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Operational\Order;
use App\Models\MasterData\Vehicle;
use App\Models\MasterData\Employee;

class OrderDriver extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'order_drivers';

    protected $fillable = [
        'order_id',
        'vehicle_id',
        'driver_id',
        'route_from',
        'route_to',
        'cost',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // logs
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['order_id', 'vehicle_id', 'driver_id', 'route_from', 'route_to', 'cost', 'created_by', 'updated_by', 'deleted_by']);
    }

    // relasi dengan order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    // relasi dengan vehicle
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }

    // relasi dengan employee
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'driver_id', 'id');
    }


}
