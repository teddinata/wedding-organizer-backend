<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
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
        'name',
        'product_attribute_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // relation to product
    public function product_attributes()
    {
        return $this->belongsTo(ProductAttribute::class, 'product_attribute_id', 'id');
    }

    // logs activity
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['product_attribute_id', 'attribute_id', 'created_by', 'updated_by', 'deleted_by']);
    }
}
