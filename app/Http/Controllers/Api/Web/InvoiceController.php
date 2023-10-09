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
use App\Http\Requests\Invoice\UpdateInvoiceRequest;

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
        // generate invoice code
        $invoice_code = 'INV-' . str_pad(Invoice::whereDate('created_at', now())->count() + 1, 6, '0', STR_PAD_LEFT) . '-V-' . date('Y/m/d');

        // store data
        $invoice = [
            'order_id' => request('order_id'),
            'bank_account_id' => request('bank_account_id'),
            //  generate invoice code INV-0000492-V-2023/08/01-00001 (INV-
            'invoice_code' => $invoice_code,
            'transfer_date' => request('transfer_date'),
            // 'transfer_proof' => request('transfer_proof'),
            'transfer_proof_uploaded_by' => Auth::user()->id,
            'transfer_proof_uploaded_at' => now(),
            'status' => 'waiting for payment',
            'amount' => request('amount'),
        ];

        // upload transfer proof
        if ($request->hasFile('transfer_proof')) {
            $transfer_proof = $request->file('transfer_proof');
            $filename = 'transfer_proof' . '_' . rand(100000, 999999) . '_' . str_replace(' ', '_', $transfer_proof->getClientOriginalName());

            $path = $transfer_proof->storeAs('uploads/employee', $filename, 'public');

            if ($path) {
                $invoice['transfer_proof'] = $filename;
            }
        }

        // store data
        $invoice = Invoice::create($invoice);

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' store data Invoice',
            'description' => 'User ' . Auth::user()->name . ' store data Invoice',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            // properties Json
            'properties' => $invoice->toJson(),
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
        // find data
        $invoice = Invoice::findOrFail($invoice->id);

        return new InvoiceResource(true, 'Invoice detail retrieved successfully', $invoice);
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
    public function update(UpdateInvoiceRequest $request, string $id)
    {
        // dd($invoice);
        // find data
        $invoice = Invoice::findOrFail($id);
        // update data
        $invoice_id = [
            'order_id' => $request->order_id,
            'bank_account_id' => $request->bank_account_id,
            // 'invoice_code' => 'INV-'. str_pad(Order::whereDate('created_at', now())->count() + 1, 6, '0', STR_PAD_LEFT) . '-V-' . date('Y/m/d') . '-' . str_pad(Order::whereDate('created_at', now())->count() + 1, 4, '0', STR_PAD_LEFT),
            'transfer_date' => $request->transfer_date,
            'transfer_proof_uploaded_by' => Auth::user()->id,
            'transfer_proof_uploaded_at' => now(),
            'status' => $request->status,
            'amount' => $request->amount,
        ];

        // upload transfer proof
        if ($request->hasFile('transfer_proof')) {
            $transfer_proof = $request->file('transfer_proof');
            $filename = 'transfer_proof' . '_' . rand(100000, 999999) . '_' . str_replace(' ', '_', $transfer_proof->getClientOriginalName());

            $path = $transfer_proof->storeAs('uploads/employee', $filename, 'public');

            if ($path) {
                $invoice_id['transfer_proof'] = $filename;
            }
        }

        // update data
        $invoice->update($invoice_id + $request->validated());

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update data Invoice',
            'description' => 'User ' . Auth::user()->name . ' update data Invoice',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => $invoice->toJson(),
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

    // function index invoice waiting for payment
    public function indexWaitingForPayment()
    {
        // get invoices with status waiting for payment
        $query = Invoice::query()->where('status', 'waiting for payment');

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
        return new InvoiceResource(true, 'Invoice with status waiting for payment retrieved successfully', $invoices);
    }

    // invoice overdue
    public function indexOverdue()
    {
        // get invoices where created_at + 14 days < now and where status = waiting for payment
        $query = Invoice::where('status', 'waiting for payment')->whereDate('created_at', '<=', now()->subDays(14));

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
        return new InvoiceResource(true, 'Invoice with status overdue retrieved successfully', $invoices);
    }

    // index invoice paid
    public function indexPaid()
    {
        // get invoices where status = paid
        $query = Invoice::where('status', 'paid');

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
        return new InvoiceResource(true, 'Invoice with status paid retrieved successfully', $invoices);
    }
}
