<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\Operational\Order;
use App\Models\Operational\OrderTeam;
use App\Models\Operational\OrderProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use App\Http\Resources\OrderResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all order teams
        $query = OrderTeam::query();

        // filter by order_id
        if (request()->has('search')) {
            $query->where('order_id', request('search'));
        }

        // get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // get data
        $orderTeams = $query->paginate($perPage, ['*'], 'page', $page);

        // return response
        return new OrderResource(true, 'Order teams retrieved successfully', $orderTeams);
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
        // Validasi request
        // dd($request->all());
        // $request->validate([
        //     'order_product_id' => 'required|exists:order_products,id',
        //     'employee_id' => 'required|array',
        //     'employee_id.*' => 'exists:employees,id',
        //     'salary' => 'required|numeric',
        // ]);
        // dd($request->all());
        // array to string

        $product_id = $request->input('order_product_id');
        $employees = $request->input('employee_id');
        // $employee_ids = implode(',', $request->input('employee_id'));
        $salary = $request->input('salary');

        // Temukan produk berdasarkan product_id
        $product = OrderProduct::find($product_id);
        if (!$product) {
            return new OrderResource(false, 'Order product not found', null, 404);
        }

        // Jika produk ditemukan, maka cek apakah produk sudah memiliki team
        if ($product->order_team()->exists()) {
            return new OrderResource(false, 'Order product already has team', null, 400);
        }

        // Jika produk ditemukan dan belum memiliki team, maka cek apakah employee yang diinputkan sudah ada di team lain
        $employee = OrderTeam::where('employee_id', $employees)->first();
        if ($employee) {
            return new OrderResource(false, 'Employee already has team', null, 400);
        }

        // Create a new OrderTeam
        $orderTeam = OrderTeam::create([
            'order_product_id' => $product_id,
            'employee_id' => $employees,

            'salary' => $salary,
        ]);
        // $orderTeam->employees()->attach($employee_ids);
        // multiple insert employee to order_team table

        // // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' store data Assign Team',
            'description' => 'User ' . Auth::user()->name . ' store data Assign Team',
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
        return new OrderResource(true, 'Order team created successfully', $orderTeam);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderTeam $orderTeam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderTeam $orderTeam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderTeam $orderTeam)
    {
        // update like store function above
        $orderTeam->update([
            'order_product_id' => $request->order_product_id,
            'employee_id' => $request->employee_id,
            'salary' => $request->salary,
        ]);

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update data Assign Team',
            'description' => 'User ' . Auth::user()->name . ' update data Assign Team',
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
        return new OrderResource(true, 'Order team updated successfully', $orderTeam);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderTeam $orderTeam)
    {
        // delete order team
        $orderTeam->delete();
        // deleted_by
        $orderTeam->deleted_by = Auth::user()->id;
        $orderTeam->save();

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete data Assign Team',
            'description' => 'User ' . Auth::user()->name . ' delete data Assign Team',
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
        return new OrderResource(true, 'Order team deleted successfully', $orderTeam);
    }
}
