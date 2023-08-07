<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

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

        // return response
        return response()->json([
            'success' => true,
            'message' => 'Invoices retrieved successfully.',
            'data' => $invoices
        ], 200);
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
    public function store(Request $request)
    {
        // validate request
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'transfer_date' => 'required|date',
            'transfer_proof' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'transfer_proof_uploaded_by' => 'required|string',
            'transfer_proof_uploaded_at' => 'required|string',
            'due_date' => 'required|date',
            'amount' => 'required|integer',
        ]);

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
        ]);

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
        return response()->json([
            'success' => true,
            'message' => 'Invoice created successfully.',
            'data' => $invoice
        ], 201);

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
    public function update(Request $request, Invoice $invoice)
    {
        // validate request
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'transfer_date' => 'required|date',
            'transfer_proof' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'transfer_proof_uploaded_by' => 'required|string',
            'transfer_proof_uploaded_at' => 'required|string',
            'due_date' => 'required|date',
            'amount' => 'required|integer',
        ]);

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
        ]);

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
        return response()->json([
            'success' => true,
            'message' => 'Invoice updated successfully.',
            'data' => $invoice
        ], 200);
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
        return response()->json([
            'success' => true,
            'message' => 'Invoice deleted successfully.',
            'data' => $invoice
        ], 200);
    }
}
