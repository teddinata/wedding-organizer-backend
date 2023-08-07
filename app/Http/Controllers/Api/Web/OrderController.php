<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all order data
        $query = Order::query();

        // filter by vendor_id
        if (request()->has('vendor_id')) {
            $query->where('vendor_id', request('vendor_id'));
        }

        // filter by event date
        if (request()->has('event_date')) {
            $query->where('event_date', request('event_date'));
        }

        // get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // get data
        $orders = $query->paginate($perPage, ['*'], 'page', $page);

        // return response
        return response()->json([
            'success' => true,
            'message' => 'Orders retrieved successfully.',
            'data' => $orders
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
            'vendor_id' => 'required|exists:vendors,id',
            'sales_id' => 'required|exists:sales,id',
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'loading_date' => 'required|date',
            'loading_time' => 'required',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'venue' => 'required',
            'room' => 'nullable',
            'coordinator_schedule' => 'nullable',
            // subtotal
            'subtotal' => 'required|integer',
            'discount' => 'required|integer',
            'total' => 'required|integer',
            'order_notes' => 'nullable',
            'is_checklist_tree' => 'nullable',
            'is_checklist_melamin' => 'nullable',
            'is_checklist_lighting' => 'nullable',
            'is_checklist_gazebo' => 'nullable',
            'points' => 'nullable',
            'extra_points' => 'nullable',
            'notes' => 'nullable',
        ]);

        // create new order
        $order = Order::create([
            'vendor_id' => $request->vendor_id,
            'sales_id' => $request->sales_id,
            'employee_id' => $request->employee_id,
            'order_number' => 'GO-' . str_pad(Order::whereDate('created_at', now())->count() + 1, 6, '0', STR_PAD_LEFT) . '-V-' . date('Y/m/d') . '-' . str_pad(Order::whereDate('created_at', now())->count() + 1, 4, '0', STR_PAD_LEFT),

            'date' => $request->date,
            'loading_date' => $request->loading_date,
            'loading_time' => $request->loading_time,
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,
            'venue' => $request->venue,
            'room' => $request->room,
            'coordinator_schedule' => $request->coordinator_schedule,
            // subtotal
            'subtotal' => $request->subtotal,
            'discount' => $request->discount,
            'total' => $request->subtotal - $request->discount,
            'order_notes' => $request->order_notes,
            'is_checklist_tree' => $request->is_checklist_tree,
            'is_checklist_melamin' => $request->is_checklist_melamin,
            'is_checklist_lighting' => $request->is_checklist_lighting,
            'is_checklist_gazebo' => $request->is_checklist_gazebo,
            'points' => $request->points,
            'extra_points' => $request->extra_points,
            'notes' => $request->notes,
            'created_by' => Auth::user()->id,
        ]);
        // order seq auto increment dan setelah melewati jam 12 malam, maka akan direset gunakan format 004
        $order->order_seq = str_pad(Order::whereDate('created_at', now())->count(), 3, '0', STR_PAD_LEFT);
        $order->save();
        // dd($order);
        // logs activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' create data Order ' . $order->name,
            'description' => 'User ' . Auth::user()->name . ' create data Order ' . $order->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => $order->toJson(),
        ]);

        // return response
        return response()->json([
            'success' => true,
            'message' => 'Order created successfully.',
            'data' => $order
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        // validate request
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'sales_id' => 'required|exists:sales,id',
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'loading_date' => 'required|date',
            'loading_time' => 'required',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'venue' => 'required',
            'room' => 'nullable',
            'coordinator_schedule' => 'nullable',
            // subtotal
            'subtotal' => 'required|integer',
            'discount' => 'required|integer',
            'total' => 'required|integer',
            'order_notes' => 'nullable',
            'is_checklist_tree' => 'nullable',
            'is_checklist_melamin' => 'nullable',
            'is_checklist_lighting' => 'nullable',
            'is_checklist_gazebo' => 'nullable',
            'points' => 'nullable',
            'extra_points' => 'nullable',
            'notes' => 'nullable',
        ]);

        // update order
        $order->update([
            'vendor_id' => $request->vendor_id,
            'sales_id' => $request->sales_id,
            'employee_id' => $request->employee_id,
            // 'order_number' => 'GO-' . str_pad(Order::whereDate('created_at', now())->count() + 1, 6, '0', STR_PAD_LEFT) . '-V-' . date('Y/m/d') . '-' . str_pad(Order::whereDate('created_at', now())->count() + 1, 4, '0', STR_PAD_LEFT),

            'date' => $request->date,
            'loading_date' => $request->loading_date,
            'loading_time' => $request->loading_time,
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,
            'venue' => $request->venue,
            'room' => $request->room,
            'coordinator_schedule' => $request->coordinator_schedule,
            // subtotal
            'subtotal' => $request->subtotal,
            'discount' => $request->discount,
            'total' => $request->subtotal - $request->discount,
            'order_notes' => $request->order_notes,
            'is_checklist_tree' => $request->is_checklist_tree,
            'is_checklist_melamin' => $request->is_checklist_melamin,
            'is_checklist_lighting' => $request->is_checklist_lighting,
            'is_checklist_gazebo' => $request->is_checklist_gazebo,
            'points' => $request->points,
            'extra_points' => $request->extra_points,
            'notes' => $request->notes,
            'updated_by' => Auth::user()->id,
        ]);

        // logs activity
        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update data Order ' . $order->name,
            'description' => 'User ' . Auth::user()->name . ' update data Order ' . $order->name,
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
            'message' => 'Order updated successfully.',
            'data' => $order
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // find order by id
        $order = Order::findOrFail($order->id);

        // delete order
        $order->delete();

        // deleted by
        $order->update([
            'deleted_by' => Auth::user()->id,
        ]);

        // logs activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete data Order ' . $order->name,
            'description' => 'User ' . Auth::user()->name . ' delete data Order ' . $order->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => $order->toJson(),
        ]);

        // return response
        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully.',
            'data' => $order
        ], 200);
    }
}
