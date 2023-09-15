<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'employees';

    protected $fillable = [
        'department_id',
        'position_id',
        'level_id',
        'photo',
        'fullname',
        'nik',
        'email',
        'email_verified_at',
        'password',
        'otp',
        'otp_verified_at',
        'reset_token',
        'notification_token',
        'dateofbirth',
        'gender',
        'ktp_img',
        'vaccine_img',
        'salary',
        'loan_limit',
        'active_loan_limit',
        'points',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // logs
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['department_id',
                    'position_id',
                    'level_id',
                    'photo',
                    'fullname',
                    'nik',
                    'email',
                    'email_verified_at',
                    // 'password',
                    'otp',
                    'otp_verified_at',
                    'reset_token',
                    'notification_token',
                    'dateofbirth',
                    'gender',
                    'ktp_img',
                    'vaccine_img',
                    'salary',
                    'loan_limit',
                    'active_loan_limit',
                    'points',
                    'is_active',
                    'created_by',
                    'updated_by',
                    'deleted_by',
                ]);
    }

    // relasi dengan user
    public function user()
    {
        return $this->belongsToMany(User::class, 'user_employees', 'employee_id', 'user_id');
    }

    public function team_member()
    {
        return $this->belongsToMany(Team::class, 'team_members', 'employee_id', 'team_id')->withTimestamps();
    }

    // relasi dengan employee allowance
    public function employee_allowance()
    {
        return $this->hasMany(EmployeeAllowance::class, 'employee_id', 'id');
    }

    // relasi dengan order
    public function order()
    {
        return $this->belongsToMany(Order::class, 'employee_id', 'id');
    }

    // relasi dengan order team
    public function order_team()
    {
        return $this->belongsToMany(OrderTeam::class, 'employee_id', 'id');
    }

    // relasi dengan department id
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    // relasi dengan position id
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

    // relasi dengan level id
    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }
}
