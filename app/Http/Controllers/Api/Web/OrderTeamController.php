<?php

namespace App\Http\Controllers\Api\Web;

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
            'product_id' => 'required|exists:order_products,id',
            // 'employee_id' => 'required|exists:employees,id',
            'employees' => 'required|array',
            'salary' => 'required|integer',
        ]);

        $product_id = $request->input('product_id');
        $employees = $request->input('employees');
        $salary = $request->input('salary');

        // Temukan produk berdasarkan product_id
        $product = OrderProduct::find($product_id);

        if ($product) {
            foreach ($employees as $employee_id) {
                // Cek apakah employee_id sudah ada terhubung dengan produk ini
                $existingEmployee = $product->order->employee()->where('employee_id', $employee_id)->first();

                if (!$existingEmployee) {
                    // Tambahkan employee ke produk dengan informasi gaji
                    $product->order->employee()->attach($employee_id, ['salary' => $salary]);
                } else {
                    // Jika employee sudah terhubung dengan produk, update gaji
                    $product->order->employee()->updateExistingPivot($employee_id, ['salary' => $salary]);
                }
            }

            return response()->json(['message' => 'Employees added to product successfully']);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }




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
            'data' => $product
        ], 201);
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
