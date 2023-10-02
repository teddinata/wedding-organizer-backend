<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
// use Spatie\Activitylog\Traits\LogsActivity;
// use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function getPermissionArray()
    {
        return $this->getAllPermissions()->mapWithKeys(function($pr){
            return [$pr['name'] => true];
        });

    }

    public function model_has_roles()
    {
        return $this->hasMany('App\Models\Model_Has_Roles', 'model_id', 'id');
    }

    // relasi dengan table employee
    public function employee()
    {
        return $this->hasOne('App\Models\Employee', 'user_id', 'id');
    }

    // transfer_proof_uploaded_by
    public function transferProofUploadedBy()
    {
        return $this->belongsTo(Invoice::class, 'transfer_proof_uploaded_by', 'id');
    }

    // public function team_lead()
    // {
    //     return $this->belongsToMany(Team::class, 'team_lead', 'user_id', 'team_id')->withTimestamps();
    // }


    // public function getActivitylogOptions(): LogOptions
    // {
    //     return LogOptions::defaults()
    //         ->logOnly(['name', 'email', 'password'])
    //         ->useLogName('User')
    //         ->logOnlyDirty();
    // }

}
