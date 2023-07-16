<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Model_Has_Roles extends Model
{
    use HasFactory;
    protected $table = 'model_has_roles';

    protected $fillable = [
        'role_id',
        'model_type',
        'model_id',
    ];

    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = 'model_id';

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }
}
