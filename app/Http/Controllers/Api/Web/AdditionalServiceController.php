<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;
// use resource
use App\Http\Resources\AdditionalServiceResource;
// model
use App\Models\MasterData\AdditionalService;
// request
use App\Http\Requests\AdditionalService\StoreAdditionalServiceRequest;

class AdditionalServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        //set variable for search
        $search = $request->query('search');

        //set condition if search not empty then search by account_holder or account_number else then show all data
        if (!empty($search)) {
            $query = AdditionalService::where('name', 'like', '%' . $search . '%')
                ->paginate(
                    $perPage,
                    ['*'],
                    'page',
                    $page
                );

            //check result
            $recordsTotal = $query->count();
            if (empty($recordsTotal)) {
                return response(['Message' => 'Data not found!'], 404);
            }
        } else {
            // get bank account data and sort by account_holder ascending
            $query = AdditionalService::orderBy('name', 'asc')->paginate($perPage, ['*'], 'page', $page);
        }

        // return json response
        return new AdditionalServiceResource(true, 'Additional Services retrieved successfully', $query);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdditionalServiceRequest $request)
    {
        // create new additional service
        $query = AdditionalService::create([
            'name' => $request->name,
            'created_by' => auth()->user()->id,
        ] + $request->validated());

        // activity logs
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' add new service',
            'description' => 'User ' . Auth::user()->name . ' create additional service',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return new AdditionalServiceResource(true, $query->name . ' has successfully been created', $query);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAdditionalServiceRequest $request, string $id)
    {
        // find data by ID
        $query = AdditionalService::findOrFail($id);

        // update data
        $query->update([
            'name' => $request->name,
            'updated_by' => auth()->user()->id,
        ] + $request->validated());

        // logs
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update service information',
            'description' => 'User ' . Auth::user()->name . ' update data additional service',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return new AdditionalServiceResource(true, $query->name . ' has successfully been updated.', $query);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // find data by id
        $query = AdditionalService::findOrFail($id);
        $query->delete();
        // soft delete to database
        $query->deleted_by = auth()->user()->id;
        $query->save();

        // logs
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete data Additional Service',
            'description' => 'User ' . Auth::user()->name . ' delete data Additional Service',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return new AdditionalServiceResource(true, $query->name . ' has successfully been deleted', $query);
    }
}
