<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'logo',
        'code',
        'name',
        'contact_person',
        'contact_number',
        'website',
        'instagram',
        'address',
        'city',
        'limit_id',
        'grade_id',
        'membership_id',
    ];
}
