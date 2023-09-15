<?php

namespace App\Models\Operational;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderTeam extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'order_teams';

    protected $fillable = [
        'employee_id',
        'order_product_id',
        'team_id',
        'salary',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // logs
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['employee_id', 'order_product_id', 'team_id', 'salary', 'created_by', 'updated_by', 'deleted_by']);
    }

    // relasi dengan order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    // relasi dengan employee
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_id', 'id');
    }
    // public function employees()
    // {
    //     return $this->belongsToMany(Employee::class, 'order_employee', 'order_team_id', 'employee_id');
    // }


    // relasi dengan order product
    public function order_product()
    {
        return $this->belongsTo(OrderProduct::class, 'order_product_id', 'id');
    }
}
