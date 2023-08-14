<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\Order;
use App\Models\OrderTeam;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

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
        if (request()->has('order_id')) {
            $query->where('order_id', request('order_id'));
        }

        // get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // get data
        $orderTeams = $query->paginate($perPage, ['*'], 'page', $page);

        // return response
        return response()->json([
            'success' => true,
            'message' => 'Order teams retrieved successfully.',
            'data' => $orderTeams
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
            'order_product_id' => 'required|exists:order_products,id',
            'employee_id' => 'required|array',
            // 'employees.*' => 'required|exists:employees,id',
            'salary' => 'required|integer',
        ]);

        $product_id = $request->input('order_product_id');
        $employees = $request->input('employee_id');
        $salary = $request->input('salary');

        // Temukan produk berdasarkan product_id
        $product = OrderProduct::find($product_id);

        // Create a new OrderTeam
        $orderTeam = OrderTeam::create([
            'order_product_id' => $product_id,
            'salary' => $salary,
        ]);
        // multiple insert employee to order_team table
        $orderTeam->employees()->attach($employees);
        // log activity
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
        return response()->json([
            'success' => true,
            'message' => 'Assign Team created successfully.',
            'data' => $orderTeam
        ], 200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderTeam $orderTeam)
    {
        //
    }
}
