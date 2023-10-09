<?php

namespace App\Models\Operational;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\MasterData\ProductAttribute;
use App\Models\MasterData\ProductVariant;
use App\Models\MasterData\DecorationArea;
use App\Models\Operational\Order;
use App\Models\Operational\OrderTeam;

class OrderProduct extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'order_products';

    protected $fillable = [
        'order_id',
        'product_attribute_id',
        'product_variant_id', // tambahan
        'area_id',
        'slug',
        'quantity',
        'amount',
        'notes',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // logs
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['order_id', 'product_attribute_id', 'product_variant_id', 'area_id', 'slug', 'quantity', 'amount', 'notes', 'created_by', 'updated_by', 'deleted_by']);
    }

    // relasi dengan order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    // relasi dengan product attribute
    public function product_attribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'product_attribute_id', 'id');
    }

    // relasi dengan product variant
    public function product_variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id', 'id');
    }

    // relasi dengan decoration area
    public function area()
    {
        return $this->belongsTo(DecorationArea::class, 'area_id', 'id');
    }

    // relasi dengan order team
    public function order_team()
    {
        return $this->hasMany(OrderTeam::class, 'order_product_id', 'id');
    }
}
