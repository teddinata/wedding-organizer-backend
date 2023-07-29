<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttribute extends Model
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
        'product_category_id',
        'name',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // relation to product category
    public function product_category()
    {
        return $this->belongsTo(Product::class, 'product_category_id', 'id');
    }

    // 1 product attribute memiliki banyak product variant
    public function product_variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_attribute_id', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    // logs activity
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['product_category_id', 'name', 'created_by', 'updated_by', 'deleted_by']);
    }
}
