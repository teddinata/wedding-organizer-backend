<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;
// use resource
use App\Http\Resources\AdditionalService\AdditionalServiceCollection;
use App\Http\Resources\AdditionalService\AdditionalServiceResource;
// model
use App\Models\MasterData\AdditionalService;
// request
use App\Http\Requests\AdditionalService\StoreAdditionalServiceRequest;

class AdditionalServiceController extends Controller
{
    // use traits for success and error JSON response
    use ApiResponseTrait;

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

        //set condition if search not empty then search by name
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
            // get additional service data and sort by name ascending
            $query = AdditionalService::orderBy('name', 'asc')->paginate($perPage, ['*'], 'page', $page);
        }

        //return resource collection
        return new AdditionalServiceCollection(true, 'Additional Service retrieved successfully', $query);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdditionalServiceRequest $request)
    {
        try {
            // create new additional service
            $query = AdditionalService::create([
                'name' => $request->name,
                'created_by' => auth()->user()->id,
            ] + $request->validated());

            // activity log
            activity('created')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new AdditionalServiceResource($query), $query->name . ' has been created successfully.');
        } catch (\Throwable $th) {
            return $this->errorResponse('Data failed to save. Please try again!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // find the data by id
        $query = AdditionalService::findOrFail($id);

        //return JSON response
        return $this->successResponse(new AdditionalServiceResource($query), 'Data found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAdditionalServiceRequest $request, string $id)
    {
        try {
            // find the data by id

            $query = AdditionalService::findOrFail($id);

            // update data
            $query->update([
                'name' => $request->name,
                'updated_by' => auth()->user()->id,
            ] + $request->validated());

            // activity log
            activity('updated')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new AdditionalServiceResource($query), 'Changes has been successfully saved.');
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'An error occurred. Data failed to update!'], 409);
        }
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

        // activity log
        activity('deleted')
            ->performedOn($query)
            ->causedBy(Auth::user());

        // return JSON response
        return $this->successResponse(new AdditionalServiceResource($query), $query->name . ' has been deleted successfully.');
    }
}
