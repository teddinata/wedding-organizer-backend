<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\Sales;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;


class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all product categories with filter and pagination
        $query = Sales::query();

        // filter by name
        if (request()->has('name')) {
            $query->where('name', 'like', '%' . request('name') . '%');
        }

        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // Get data
        $sales = $query->paginate($perPage, ['*'], 'page', $page);

        // Log Activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' show data Sales',
            'description' => 'User ' . Auth::user()->name . ' show data Sales',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return response()->json([
            'success' => true,
            'message' => 'Sales retrieved successfully.',
            'data' => $sales
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
        // validate incoming request
        $request->validate([
            'name' => 'required|string',
        ], [
            'name.required' => 'Name is required!'
        ]);

        try {
            $sales = new Sales;
            $sales->name = $request->input('name');
            $sales->created_by = Auth::user()->id;
            $sales->save();

            // activity log
            Activity::create([
                'log_name' => 'User ' . Auth::user()->name . ' create data Sales ' . $sales->name,
                'description' => 'User ' . Auth::user()->name . ' create data Sales ' . $sales->name,
                'subject_id' => Auth::user()->id,
                'subject_type' => 'App\Models\User',
                'causer_id' => Auth::user()->id,
                'causer_type' => 'App\Models\User',
                'properties' => request()->ip(),
                // 'host' => request()->ip(),
                'created_at' => now()
            ]);

            // return json response
            return response()->json([
                'success' => true,
                'message' => 'Sales saved successfully.',
                'data' => $sales
            ], 201);
        } catch (\Exception $e) {

            // return json response
            return response()->json([
                'success' => false,
                'message' => 'Sales failed to save.',
                'data' => $e->getMessage()
            ], 409);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sales $sales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sales $sales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sales $sales)
    {
        // validate incoming request
        $request->validate([
            'name' => 'required|string|max:255,' . $sales->id,
        ]);

        //$sales = Sales::findOrFail($sales->id);

        try {
            $sales->name = $request->input('name');
            $sales->updated_by = Auth::user()->id;
            $sales->save();

            // activity log
            Activity::create([
                'log_name' => 'User ' . Auth::user()->name . ' update data Sales ' . $sales->name,
                'description' => 'User ' . Auth::user()->name . ' update data Sales ' . $sales->name,
                'subject_id' => Auth::user()->id,
                'subject_type' => 'App\Models\User',
                'causer_id' => Auth::user()->id,
                'causer_type' => 'App\Models\User',
                'properties' => request()->ip(),
                // 'host' => request()->ip(),
                'updated_at' => now()
            ]);

            // return json response
            return response()->json([
                'success' => true,
                'message' => 'Sales updated successfully.',
                'data' => $sales
            ], 201);
        } catch (\Exception $e) {

            // return json response
            return response()->json([
                'success' => false,
                'message' => 'Sales failed to update.',
                'data' => $e->getMessage()
            ], 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        // get product category
        $sales = Sales::findOrFail($id);

        try {
            $sales->delete();
            // deleted by
            $sales->deleted_by = Auth::user()->id;
            $sales->save();

            // activity log
            Activity::create([
                'log_name' => 'User ' . Auth::user()->name . ' delete data Sales ' . $sales->name,
                'description' => 'User ' . Auth::user()->name . ' delete data Sales ' . $sales->name,
                'subject_id' => Auth::user()->id,
                'subject_type' => 'App\Models\User',
                'causer_id' => Auth::user()->id,
                'causer_type' => 'App\Models\User',
                'properties' => request()->ip(),
                // 'host' => request()->ip(),
            ]);

            // return json response
            return response()->json([
                'success' => true,
                'message' => 'Sales deleted successfully.',
                'data' => $sales
            ], 201);
        } catch (\Exception $e) {

            // return json response
            return response()->json([
                'success' => false,
                'message' => 'Sales failed to delete.',
                'data' => $e->getMessage()
            ], 409);
        }
    }
}
