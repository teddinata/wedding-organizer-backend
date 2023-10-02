<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderDriver\OrderDriverRequest;
use Illuminate\Http\Request;
use App\Http\Resources\Resource;
use App\Models\Operational\OrderDriver;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use App\Models\Operational\Order;
use App\Models\MasterData\Vehicle;

class OrderDriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all order teams
        $query = OrderDriver::with(['order', 'vehicle', 'employee']);

        // get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // get data
        $orderDriver = $query->paginate($perPage, ['*'], 'page', $page);

        // return response
        return new Resource(true, 'Order drivers retrieved successfully', $orderDriver);
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
    public function store(OrderDriverRequest $request)
    {
        // create
        // $orderDriver = OrderDriver::create([
        //     'order_id' => $request->order_id,
        //     'vehicle_id' => $request->vehicle_id,
        //     'driver_id' => $request->driver_id,
        //     'route_from' => $request->route_from,
        //     'route_to' => $request->route_to,
        //     'cost' => $request->cost,
        //     'created_by' => auth()->user()->id,
        // ] + $request->validated());

        $employee_ids = $request->driver_id;
        // dd($employee_ids);

        // pengecekan apakah employee_id sudah ada di driver
        foreach ($employee_ids as $employee_id) {
            $orderDriver = OrderDriver::where('order_id', $request->order_id)->where('driver_id', $employee_id)->first();
            // dd($orderDriver);
            // check order not found
            $order = Order::where('id', $request->order_id)->first();
            if (!$order) {
                return response()->json(['message' => 'Order not found'], 422);
            }
            // check vehicle not found
            $vehicle = Vehicle::where('id', $request->vehicle_id)->first();
            if (!$vehicle) {
                return response()->json(['message' => 'Vehicle not found'], 422);
            }
            if ($orderDriver) {
                return response()->json(['message' => 'Driver have already in this order'], 422);
            } else {
                $orderDriver = OrderDriver::create([
                    'order_id' => $request->order_id,
                    'vehicle_id' => $request->vehicle_id,
                    'driver_id' => $employee_id,
                    'route_from' => $request->route_from,
                    'route_to' => $request->route_to,
                    'cost' => $request->cost,
                    'created_by' => auth()->user()->id,
                ]);
            }
        }

        // logs
        // // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' store data Assign Driver',
            'description' => 'User ' . Auth::user()->name . ' store data Assign Driver',
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
        return new Resource(true, 'Order driver created successfully', $orderDriver);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // update
        $orderDriver = OrderDriver::find($id);

        // check order not found
        $order = Order::where('id', $request->order_id)->first();
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 422);
        }

        // check vehicle not found
        $vehicle = Vehicle::where('id', $request->vehicle_id)->first();
        if (!$vehicle) {
            return response()->json(['message' => 'Vehicle not found'], 422);
        }

        // update order driver like store function
        $employee_ids = $request->driver_id;

        foreach ($employee_ids as $employee_id) {
            // pengecekan data employee_id sudah ada di driver berdasarkan id
            $orderDriver = OrderDriver::where('order_id', $request->order_id)->where('driver_id', $employee_id)->find($id);
            if ($orderDriver) {
                return response()->json(['message' => 'Driver have already in this order'], 422);
            } else {
                // update order driver
                $orderDriver->order_id = $request->order_id;
                $orderDriver->vehicle_id = $request->vehicle_id;
                $orderDriver->driver_id = $employee_id;
                $orderDriver->route_from = $request->route_from;
                $orderDriver->route_to = $request->route_to;
                $orderDriver->cost = $request->cost;
                $orderDriver->updated_by = auth()->user()->id;
                $orderDriver->save();
            }
        }

        // // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update data Assign Driver',
            'description' => 'User ' . Auth::user()->name . ' update data Assign Driver',
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
        return new Resource(true, 'Order driver updated successfully', $orderDriver);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // delete
        $orderDriver = OrderDriver::find($id);

        // delete order driver
        $orderDriver->delete();

        // deleted by
        $orderDriver->deleted_by = Auth::user()->id;
        $orderDriver->save();

        // logs
        // // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete data Assign Driver',
            'description' => 'User ' . Auth::user()->name . ' delete data Assign Driver',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => $orderDriver->toJson(),
        ]);

        // return response
        return new Resource(true, 'Order driver deleted successfully', $orderDriver);
    }
}
