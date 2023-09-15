<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\Operational\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use App\Models\Operational\Order;
// use resource
use App\Http\Resources\InvoiceResource;
use App\Http\Requests\Invoice\StoreInvoiceRequest;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all invoices
        $query = Invoice::query();

        // filter by order_id
        if (request()->has('order_id')) {
            $query->where('order_id', request('order_id'));
        }

        // get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // get data
        $invoices = $query->paginate($perPage, ['*'], 'page', $page);

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' show data Invoice',
            'description' => 'User ' . Auth::user()->name . ' show data Invoice',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return response
        return new InvoiceResource(true, 'Invoice retrieved successfully', $invoices);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        // store data
        $invoice = Invoice::create([
            'order_id' => request('order_id'),
            'bank_account_id' => request('bank_account_id'),
            //  generate invoice code INV-0000492-V-2023/08/01-00001 (INV-
            'invoice_code' => 'INV-'. str_pad(Order::whereDate('created_at', now())->count() + 1, 6, '0', STR_PAD_LEFT) . '-V-' . date('Y/m/d') . '-' . str_pad(Order::whereDate('created_at', now())->count() + 1, 4, '0', STR_PAD_LEFT),
            'transfer_date' => request('transfer_date'),
            'transfer_proof' => request('transfer_proof'),
            'transfer_proof_uploaded_by' => request('transfer_proof_uploaded_by'),
            'transfer_proof_uploaded_at' => request('transfer_proof_uploaded_at'),
            'due_date' => request('due_date'),
            'amount' => request('amount'),
        ] + $request->validated());

        // logs
        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' store data Invoice',
            'description' => 'User ' . Auth::user()->name . ' store data Invoice',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return response
        return new InvoiceResource(true, 'Invoice created successfully', $invoice);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        // update data
        $invoice->update([
            'order_id' => request('order_id'),
            'bank_account_id' => request('bank_account_id'),
            // 'invoice_code' => 'INV-'. str_pad(Order::whereDate('created_at', now())->count() + 1, 6, '0', STR_PAD_LEFT) . '-V-' . date('Y/m/d') . '-' . str_pad(Order::whereDate('created_at', now())->count() + 1, 4, '0', STR_PAD_LEFT),
            'transfer_date' => request('transfer_date'),
            'transfer_proof' => request('transfer_proof'),
            'transfer_proof_uploaded_by' => request('transfer_proof_uploaded_by'),
            'transfer_proof_uploaded_at' => request('transfer_proof_uploaded_at'),
            'due_date' => request('due_date'),
            'amount' => request('amount'),
        ] + $request->validated());

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update data Invoice',
            'description' => 'User ' . Auth::user()->name . ' update data Invoice',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return response
        return new InvoiceResource(true, 'Invoice updated successfully', $invoice);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        // find data
        $invoice = Invoice::findOrFail($invoice->id);

        // delete data
        $invoice->delete();

        // deleted by
        $invoice->deleted_by = Auth::user()->id;
        $invoice->save();

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete data Invoice',
            'description' => 'User ' . Auth::user()->name . ' delete data Invoice',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return response
        return new InvoiceResource(true, 'Invoice deleted successfully', $invoice);
    }
}
