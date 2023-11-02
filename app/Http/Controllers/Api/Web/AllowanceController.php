<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;
// use resource
use App\Http\Resources\Allowance\AllowanceCollection;
use App\Http\Resources\Allowance\AllowanceResource;
// use model
use App\Models\MasterData\Allowance;
// request
use App\Http\Requests\Allowance\StoreAllowanceRequest;
use App\Http\Requests\Allowance\UpdateAllowanceRequest;

class AllowanceController extends Controller
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
            $query = Allowance::where('name', 'like', '%' . $search . '%')->with('departments')->get();
        } else {
            // get additional service data and sort by name ascending
            $query = Allowance::orderBy('name', 'asc')->with('departments')->get();
        }

        // request by id then show detail data, not array
        if ($request->has('id')) {
            $id = $request->input('id');

            // find the data by id
            $query = Allowance::with('departments')->findOrFail($id);

            //return JSON response
            return $this->successResponse(new AllowanceResource($query), 'Data found.');
        }

        //return resource collection
        $showData = new AllowanceCollection(true, 'Allowance retrieved successfully', $query);
        return  $showData->paginate($perPage, $page);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAllowanceRequest $request)
    {
        try {
            // create new additional service
            $query = Allowance::create([
                'name' => $request->name,
            ] + $request->validated());

            // activity log
            activity('created')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new AllowanceResource($query), $query->name . ' has been created successfully.');
        } catch (\Throwable $th) {
            return $this->errorResponse('Data failed to save. Please try again!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Allowance $allowance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAllowanceRequest $request, string $id)
    {
        try {
            // find the data by id

            $query = Allowance::findOrFail($id);

            // update data
            $query->update([
                'name' => $request->name,
            ] + $request->validated());

            // activity log
            activity('updated')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new AllowanceResource($query), 'Changes has been successfully saved.');
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'An error occurred. Data failed to update!'], 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find data by id
        $query = Allowance::findOrFail($id);
        $query->delete();
        $query->save();

        // activity log
        activity('deleted')
            ->performedOn($query)
            ->causedBy(Auth::user());

        // return JSON response
        return $this->successResponse(new AllowanceResource($query), $query->name . ' has been deleted successfully.');
    }
}
