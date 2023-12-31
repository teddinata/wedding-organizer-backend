<?php

namespace App\Models\Operational;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

// user
use App\Models\User;

// order
use App\Models\Operational\Order;

// bank account
use App\Models\MasterData\BankAccount;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'invoices';

    protected $fillable = [
        'order_id',
        'bank_account_id',
        'invoice_number',
        'amount',
        'transfer_proof',
        'transfer_date',
        'transfer_proof_uploaded_at',
        'transfer_proof_uploaded_by',
        'status',
        'amount',
        'created_at',
        'updated_at',
        'deleted_at',
        // 'invoice_status_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // logs
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['order_id', 'bank_account_id', 'invoice_number', 'amount', 'transfer_proof', 'transfer_date', 'transfer_proof_uploaded_at', 'transfer_proof_uploaded_by', 'status', 'created_by', 'updated_by', 'deleted_by']);
    }

    // relasi dengan order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    // relasi dengan bank account
    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id', 'id');
    }

    // transfer_proof_uploaded_by
    public function transferProofUploadedBy()
    {
        return $this->belongsTo(User::class, 'transfer_proof_uploaded_by', 'id');
    }

    // relasi dengan invoice status
    // public function invoiceStatus()
    // {
    //     return $this->belongsTo(InvoiceStatus::class, 'invoice_status_id', 'id');
    // }
}
