<?php

namespace App\Models\MasterData;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    // declare table name
    protected $table = 'bank_accounts';

    // this field must type date yyyy-mm-dd hh:mm:ss
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // declare fillable fields
    protected $fillable = [
        'bank',
        'account_holder',
        'account_number',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // logs
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['bank', 'account_holder', 'account_number', 'created_by', 'updated_by', 'deleted_by'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn (string $eventName) => auth()->user()->name . " {$eventName} sales")
            ->useLogName('Master Bank Account log');
    }

    // one bank account has many invoice
    public function invoice()
    {
        return $this->hasMany(Invoice::class, 'bank_account_id', 'id');
    }
}
