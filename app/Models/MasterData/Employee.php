<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Operational\Order;
use App\Models\Operational\OrderTeam;
use App\Models\MasterData\Department;
use App\Models\MasterData\Position;
use App\Models\MasterData\Level;
use App\Models\Operational\OrderDriver;

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
        'phone_number',
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
                    'phone_number',
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

    // relasi dengan employee allowance
    public function employee_allowance()
    {
        return $this->hasMany(Allowance::class, 'employee_id', 'id');
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

    public function lead()
    {
        return $this->belongsToMany(Team::class, 'team_leads', 'employee_id', 'team_id')->withTimestamps();
    }

    public function member()
    {
        return $this->hasMany(TeamMember::class, 'team_members', 'employee_id', 'team_id');
    }

    // relasi dengan order driver
    public function order_driver()
    {
        return $this->belongsToMany(OrderDriver::class, 'driver_id', 'id');
    }
}
