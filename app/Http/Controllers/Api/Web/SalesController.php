<?php

namespace App\Http\Controllers\Api\Web;

// model
use App\Models\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
// use resource
use App\Http\Resources\SalesResource;
// validator
use Illuminate\Support\Facades\Validator;


class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get sales data and sort by name ascending
        $sales = Sales::orderBy('name', 'asc')->paginate(10);
        //return collection of sales as a resource
        return new SalesResource(true, 'Sales retrieved successfully', $sales);

        // Log Activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' show data Sales',
            'description' => 'User ' . Auth::user()->name . ' show data Sales',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'created_by' => 'required|numeric'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // create sales
        $sales = Sales::create([
            'name' => $request->name,
            'created_by' => Auth::user()->id,
        ]);

        // activity log
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' create data Sales ' . $sales->name,
            'description' => 'User ' . Auth::user()->name . ' create data Sales ' . $sales->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now()
        ]);

        // return json response
        return new SalesResource(true, 'Sales created successfully', $sales);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sales = Sales::findOrFail($id);
        //return single post as a resource
        return new SalesResource(true, 'Data Sales Found!', $sales);

        // activity log
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' view data Sales ' . $sales->name,
            'description' => 'User ' . Auth::user()->name . ' view data Sales ' . $sales->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // validate incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'updated_by' => 'required|numeric'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $sales = Sales::findOrFail($id);

        $sales->update([
            'name' => $request->name,
            'updated_by' => Auth::user()->id,
        ]);

        // activity log
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update data Product Category ' . $sales->name,
            'description' => 'User ' . Auth::user()->name . ' update data Product Category ' . $sales->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return new SalesResource(true, 'Sales updated successfully!', $sales);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // get sales
        $sales = Sales::findOrFail($id);
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
        return new SalesResource(true, 'Sales deleted successfully', null);
    }
}
