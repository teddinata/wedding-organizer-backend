<?php

namespace App\Models\Operational;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Operational\Order;
use App\Models\Operational\AdditionalService;
use App\Models\MasterData\Employee;

class OrderAdditionalService extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'order_additional_services';

    protected $fillable = [
        'order_id',
        // 'additional_service_id',
        'name',
        'employee_id',
        'salary',
    ];

    // logs
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['order_id', 'name', 'employee_id', 'salary']);
    }

    // relasi dengan order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    // relasi dengan additional service
    // public function additional_service()
    // {
    //     return $this->belongsTo(AdditionalService::class, 'additional_service_id', 'id');
    // }

    // relasi dengan employee
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
