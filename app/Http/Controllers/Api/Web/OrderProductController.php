<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\Operational\OrderProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use App\Http\Resources\OrderResource;
use App\Http\Requests\OrderProduct\StoreOrderProductRequest;

class OrderProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all order products
        $query = OrderProduct::query();

        // filter by order_id
        if (request()->has('search')) {
            $query->where('order_id', request('search'));
        }

        // get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // get data
        $orderProducts = $query->paginate($perPage, ['*'], 'page', $page);

         // log activity
         Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' get data Order Products',
            'description' => 'User ' . Auth::user()->name . ' get data Order Products',
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
        return new OrderResource(true, 'Order products retrieved successfully', $orderProducts);
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
    public function store(StoreOrderProductRequest $request)
    {
        // create order product
        $orderProduct = OrderProduct::create([
            'order_id' => $request->order_id,
            'product_attribute_id' => $request->product_attribute_id,
            'product_variant_id' => $request->product_variant_id, // tambahan
            'area_id' => $request->area_id,
            'quantity' => $request->quantity,
            'amount' => $request->amount,
            'notes' => $request->notes,
            'created_by' => Auth::user()->id,
        ] + $request->validated());

        // logs activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' create data Order ',
            'description' => 'User ' . Auth::user()->name . ' create data Order ',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => $orderProduct->toJson(),
        ]);

        // return response
        return new OrderResource(true, 'Order product created successfully', $orderProduct);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderProduct $orderProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderProduct $orderProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreOrderProductRequest $request, OrderProduct $orderProduct)
    {
        // validate request
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_attribute_id' => 'required|exists:product_attributes,id',
            'product_variant_id' => 'required|exists:product_variants,id', // tambahan
            'area_id' => 'required|exists:decoration_areas,id',
            'quantity' => 'required|integer',
            'amount' => 'required|integer',
            'notes' => 'required|string',
        ] + $request->validated());

        // update order product
        $orderProduct->update([
            'order_id' => $request->order_id,
            'product_attribute_id' => $request->product_attribute_id,
            'area_id' => $request->area_id,
            'quantity' => $request->quantity,
            'amount' => $request->amount,
            'notes' => $request->notes,
            'updated_by' => Auth::user()->id,
        ]);

        // logs activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update data Order ',
            'description' => 'User ' . Auth::user()->name . ' update data Order ',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => $orderProduct->toJson(),
        ]);

        // return response
        return new OrderResource(true, 'Order product updated successfully', $orderProduct);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // get order product
        $orderProduct = OrderProduct::findOrFail($id);

        // delete order product
        $orderProduct->delete();

        // deleted by
        $orderProduct->deleted_by = Auth::user()->id;
        $orderProduct->save();

        // logs activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete data Order ',
            'description' => 'User ' . Auth::user()->name . ' delete data Order ',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => $orderProduct->toJson(),
        ]);

        // return response
        return new OrderResource(true, 'Order product deleted successfully', $orderProduct);
    }
}
