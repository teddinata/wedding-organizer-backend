<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $fillable = [
        'name',
    ];

    //  relation to checklist item
    public function checklist_items()
    {
        return $this->hasMany(ChecklistItem::class, 'checklist_category_id', 'id');
    }
}
