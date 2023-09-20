<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\Operational\OrderAdditionalService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Requests\OrderAddOn\StoreOrderAddOnRequest;

class OrderAdditionalServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all order additional services
        $query = OrderAdditionalService::orderBy('created_at', 'asc');

        // get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // get data
        $orderAdditionalServices = $query->paginate($perPage, ['*'], 'page', $page);

        // return response
        return new OrderResource(true, 'Order additional services retrieved successfully', $orderAdditionalServices);
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
    public function store(StoreOrderAddOnRequest $request)
    {
        // create order additional service
        $orderAdditionalService = OrderAdditionalService::create([
            'order_id' => $request->order_id,
            // 'additional_service_id' => $request->additional_service_id,
            'name' => $request->name,
            'employee_id' => $request->employee_id,
            'salary' => $request->salary,
        ] + $request->validated());

        // return response
        return new OrderResource(true, 'Order additional service created successfully', $orderAdditionalService);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderAdditionalService $orderAdditionalService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderAdditionalService $orderAdditionalService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreOrderAddOnRequest $request, $id)
    {
        // find order additional service by id
        $orderAdditionalService = OrderAdditionalService::findOrFail($id);
        // dd($orderAdditionalService);
        // $orderAdditionalService = OrderAdditionalService::findOrFail($orderAdditionalService->id);
        // dd($orderAdditionalService);
        // update order additional service
        $orderAdditionalService->update([
            'order_id' => $request->order_id ?? $orderAdditionalService->order_id,
            // 'additional_service_id' => $request->additional_service_id,
            'name' => $request->name ?? $orderAdditionalService->name,
            'employee_id' => $request->employee_id ?? $orderAdditionalService->employee_id,
            'salary' => $request->salary ?? $orderAdditionalService->salary,
        ]);

        // return response
        return new OrderResource(true, 'Order additional service updated successfully', $orderAdditionalService);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find order additional service by id
        $orderAdditionalService = OrderAdditionalService::findOrFail($id);
        // delete order additional service
        $orderAdditionalService->delete();

        // return response
        return new OrderResource(true, 'Order additional service deleted successfully', $orderAdditionalService);
    }
}
