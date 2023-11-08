<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\Operational\Order;
use App\Models\Operational\OrderHistory;
use App\Models\MasterData\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use App\Http\Resources\OrderResource;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\Notification;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all order data
        $query = Order::with(['vendor']);

        // filter search by every column
        if (request()->has('search')) {
            $searchTerm = request('search');

            // Gabungkan tabel relasi employees dan cari berdasarkan employee_name
            $query->orWhereHas('vendor', function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%');
            });
        }

        if (request()->has('year')) {
            // Ambil tahun dari permintaan
            $selectedYear = request('year');

            // Filter berdasarkan tahun yang lebih besar atau sama dengan yang dipilih
            $query->whereYear('date', '=', $selectedYear);
        }

        if (request()->has('month')) {
            // Ambil bulan dari permintaan
            $selectedMonth = request('month');

            // Filter berdasarkan bulan
            $query->whereMonth('date', $selectedMonth);
        }

        if (request()->has('week_start') && request()->has('week_end')) {
            $weekStart = request('week_start');
            $weekEnd = request('week_end');

            $query->whereBetween('date', [$weekStart, $weekEnd]);
        }

        // get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // get data
        $orders = $query->paginate($perPage, ['*'], 'page', $page);

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' get data Order',
            'description' => 'User ' . Auth::user()->name . ' get data Order',
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
        return new OrderResource(true, 'Orders retrieved successfully', $orders);
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
    public function store(StoreOrderRequest $request)
    {
        // create new order
        $order = Order::create([
            'vendor_id' => $request->vendor_id,
            'sales_id' => $request->sales_id,
            'coordinator_id' => $request->coordinator_id,
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
            // 'points' => $request->points,
            // 'extra_points' => $request->extra_points,
            'notes' => $request->notes,
            'created_by' => Auth::user()->id,
        ] + $request->validated());
        // order seq auto increment dan setelah melewati jam 12 malam, maka akan direset gunakan format 004
        $order->order_seq = str_pad(Order::whereDate('created_at', now())->count(), 3, '0', STR_PAD_LEFT);
        $order->save();

        // order created then created order history
        $orderHistory = OrderHistory::create([
            'order_id' => $order->id,
            'coordinator_id' => $request->coordinator_id,
            'status' => 'new',
            // 'created_by' => Auth::user()->id,
        ]);

        // hit order history
        // $order->orderHistory()->save($orderHistory);

        $notification = new Notification();
        $notification->user_id = Auth::user()->id;
        $notification->type = 'Vendor Created';
        // data
        $notification->data = [
            'message' => 'New Order with order number ' . $order->order_number . ' has been created by ' . Auth::user()->name,
        ];
        $notification->save();

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
        return new OrderResource(true, 'Order created successfully', $order);
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
    public function update(StoreOrderRequest $request, Order $order)
    {
        // update order
        $order->update([
            'vendor_id' => $request->vendor_id,
            'sales_id' => $request->sales_id,
            'coordinator_id' => $request->coordinator_id,
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
            // 'points' => $request->points,
            // 'extra_points' => $request->extra_points,
            'notes' => $request->notes,
            'updated_by' => Auth::user()->id,
        ] + $request->validated());

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
        return new OrderResource(true, 'Order updated successfully', $order);
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
        $order->deleted_by = Auth::user()->id;
        $order->save();

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
        return new OrderResource(true, 'Order deleted successfully', $order);
    }
}
