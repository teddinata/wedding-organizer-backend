<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistItem extends Model
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
        'checklist_category_id',
        'name',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // 1 category memiliki banyak item
    public function checklist_category()
    {
        return $this->belongsTo(ChecklistCategory::class, 'checklist_category_id', 'id');
    }

    // logs activity
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['checklist_category_id', 'name', 'created_by', 'updated_by', 'deleted_by']);
    }
}
