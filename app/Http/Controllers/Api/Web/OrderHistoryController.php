<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\Operational\OrderHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use App\Http\Resources\OrderResource;

class OrderHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all order histories
        $query = OrderHistory::query();

        // get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // get data
        $orderHistories = $query->paginate($perPage, ['*'], 'page', $page);

        // return response
        return new OrderResource(true, 'Orders retrieved successfully', $orderHistories);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderHistory $orderHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderHistory $orderHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderHistory $orderHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderHistory $orderHistory)
    {
        //
    }

    // function menambahkan status order in order history by order id
    public function changeStatus(Request $request)
    {
        // Validasi request jika diperlukan
        $request->validate([
            'status' => 'required|string', // Atur validasi sesuai
            'order_id' => 'required|integer' // Atur validasi sesuai
        ]);

        $status = $request->input('status'); // Ambil status dari request
        $orderId = $request->input('order_id'); // Ambil order id dari request

        // dd($status, $orderId);

        // check apakah status order sudah ada di order history
        $orderHistory = OrderHistory::where('order_id', $orderId)->where('status', $status)->first();

        if ($orderHistory) {
            return response()->json(['message' => "Tidak dapat menambahkan status order yang sama: '{$status}'"], 400);
        }
        try {
            // Buat entri baru dalam tabel order_history
            $orderHistory = new OrderHistory;
            $orderHistory->order_id = $orderId;
            // $orderHistory->employee_id = 3;
            $orderHistory->status = $status;
            $orderHistory->save();

            return response()->json(['message' => "Status order berhasil ditambahkan: '{$status}'"]);
        } catch (\Exception $e) {
            return response()->json(['message' => "Terjadi kesalahan saat menambahkan status order: " . $e->getMessage()], 500);
        }
    }
}
