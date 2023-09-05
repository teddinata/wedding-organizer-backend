<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
// use resource
use App\Http\Resources\SalesResource;
// model
use App\Models\MasterData\Sales;
// request
use App\Http\Requests\Sales\StoreSalesRequest;
use App\Http\Requests\Sales\UpdateSalesRequest;

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
            'log_name' => 'Show Data',
            'description' => 'User ' . Auth::user()->name . ' Show sales list',
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
    public function store(StoreSalesRequest $request)
    {
        //store to database
        $sales = Sales::create([
            'name' => $request->name,
            'created_by' => Auth::user()->id,
        ] + $request->validated());

        // activity log
        Activity::create([
            'log_name' => 'Sales Creation',
            'description' => 'User ' . Auth::user()->name . ' create sales ' . $sales->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now()
        ]);

        // return json response
        return new SalesResource(true, $sales->name . ' has successfully been created.', $sales);
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
            'log_name' => 'View Data',
            'description' => 'User ' . Auth::user()->name . ' view sales ' . $sales->name,
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
    public function update(UpdateSalesRequest $request, $id)
    {
        // find the data
        $sales = Sales::findOrFail($id);

        // update to database
        $sales->update(($request->validated() + [
            'name' => $request->name,
            'updated_by' => Auth::user()->id,
        ]));

        // activity log
        Activity::create([
            'log_name' => 'Update Data',
            'description' => 'User ' . Auth::user()->name . ' update sales to ' . $sales->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return new SalesResource(true, $sales->name . ' has successfully been updated.', $sales);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find data
        $sales = Sales::findOrFail($id);
        $sales->delete();
        // soft delete to database
        $sales->deleted_by = Auth::user()->id;
        $sales->save();

        // activity log
        Activity::create([
            'log_name' => 'Delete Data',
            'description' => 'User ' . Auth::user()->name . ' delete sales ' . $sales->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
        ]);

        // return json response
        return new SalesResource(true, $sales->name . ' has successfully been deleted.', null);
    }
}
