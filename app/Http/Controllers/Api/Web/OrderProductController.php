<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

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
        if (request()->has('order_id')) {
            $query->where('order_id', request('order_id'));
        }

        // filter by product_id
        if (request()->has('product_id')) {
            $query->where('product_id', request('product_id'));
        }

        // get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // get data
        $orderProducts = $query->paginate($perPage, ['*'], 'page', $page);

        // return response
        return response()->json([
            'success' => true,
            'message' => 'Order products retrieved successfully.',
            'data' => $orderProducts
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
            'product_attribute_id' => 'required|exists:product_attributes,id',
            'area_id' => 'required|exists:decoration_areas,id',
            'quantity' => 'required|integer',
            'amount' => 'required|integer',
            'notes' => 'required|string',
        ]);

        // create order product
        $orderProduct = OrderProduct::create([
            'order_id' => $request->order_id,
            'product_attribute_id' => $request->product_attribute_id,
            'area_id' => $request->area_id,
            'quantity' => $request->quantity,
            'amount' => $request->amount,
            'notes' => $request->notes,
            'created_by' => Auth::user()->id,
        ]);

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
        return response()->json([
            'success' => true,
            'message' => 'Order product created successfully.',
            'data' => $orderProduct
        ], 201);
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
    public function update(Request $request, OrderProduct $orderProduct)
    {
        // validate request
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_attribute_id' => 'required|exists:product_attributes,id',
            'area_id' => 'required|exists:areas,id',
            'quantity' => 'required|integer',
            'amount' => 'required|integer',
            'notes' => 'required|string',
        ]);

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
        return response()->json([
            'success' => true,
            'message' => 'Order product updated successfully.',
            'data' => $orderProduct
        ], 200);
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
        return response()->json([
            'success' => true,
            'message' => 'Order product deleted successfully.',
            'data' => $orderProduct
        ], 200);
    }
}
