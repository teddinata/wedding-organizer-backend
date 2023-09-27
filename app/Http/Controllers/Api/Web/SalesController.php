<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
    public function index(Request $request)
    {
        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);
        
        //set variable for search
        $search = $request->query('search');

        //set condition if search not empty then find by name else then show all data
        if(!empty($search)){
            $query = Sales::where('name', 'like', '%' . $search . '%')->paginate($perPage, ['*'], 'page', $page);
        } else{
            // get sales data and sort by name ascending
            $query = Sales::orderBy('name', 'asc')->paginate($perPage, ['*'], 'page', $page);
        }

        //return collection of sales as a resource
        return new SalesResource(true, 'Sales retrieved successfully', $query);
                
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
        $query = Sales::create([
            'name' => $request->name,
            'created_by' => Auth::user()->id,
        ] + $request->validated());

        // activity log
        Activity::create([
            'log_name' => 'Sales Creation',
            'description' => 'User ' . Auth::user()->name . ' create sales ' . $query->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now()
        ]);

        // return json response
        return new SalesResource(true, $query->name . ' has successfully been created.', $query);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $query = Sales::findOrFail($id);
        //return single post as a resource
        return new SalesResource(true, 'Data Sales Found!', $query);

        // activity log
        Activity::create([
            'log_name' => 'View Data',
            'description' => 'User ' . Auth::user()->name . ' view sales ' . $query->name,
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
        $query = Sales::findOrFail($id);

        // update to database
        $query->update(($request->validated() + [
            'name' => $request->name,
            'updated_by' => Auth::user()->id,
        ]));

        // activity log
        Activity::create([
            'log_name' => 'Update Data',
            'description' => 'User ' . Auth::user()->name . ' update sales to ' . $query->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return new SalesResource(true, $query->name . ' has successfully been updated.', $query);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find data
        $query = Sales::findOrFail($id);
        $query->delete();
        // soft delete to database
        $query->deleted_by = Auth::user()->id;
        $query->save();

        // activity log
        Activity::create([
            'log_name' => 'Delete Data',
            'description' => 'User ' . Auth::user()->name . ' delete sales ' . $query->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
        ]);

        // return json response
        return new SalesResource(true, $query->name . ' has successfully been deleted.', null);
    }
}
