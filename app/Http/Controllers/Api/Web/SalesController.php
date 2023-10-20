<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;
// use resource
use App\Http\Resources\Sales\SalesCollection;
use App\Http\Resources\Sales\SalesResource;
// model
use App\Models\MasterData\Sales;
// request
use App\Http\Requests\Sales\StoreSalesRequest;
use App\Http\Requests\Sales\UpdateSalesRequest;

class SalesController extends Controller
{
    // use traits for success and error JSON response
    use ApiResponseTrait;

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
        if (!empty($search)) {
            $query = Sales::where('name', 'like', '%' . $search . '%')->paginate($perPage, ['*'], 'page', $page);
        } else {
            // get sales data and sort by name ascending
            $query = Sales::orderBy('name', 'asc')->paginate($perPage, ['*'], 'page', $page);
        }

        // request by id then show detail data, not array
        if ($request->has('id')) {
            $id = $request->input('id');

            // find the data by id
            $query = Sales::findOrFail($id);

            //return JSON response
            return $this->successResponse(new SalesResource($query), 'Data found.');
        }

        //return resource collection
        return new SalesCollection(true, 'Sales retrieved successfully', $query);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSalesRequest $request)
    {
        try {
            //store to database
            $query = Sales::create([
                'name' => $request->name,
            ] + $request->validated());

            // activity log
            activity('created')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new SalesResource($query), $query->name . ' has been created successfully.');
            //return (new SalesResource($query))->additional(['status' => true, 'message' => $query->name . ' has been created.']);
        } catch (\Exception $e) {
            return $this->errorResponse('Data failed to save. Please try again!');
        }
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
    public function update(UpdateSalesRequest $request, $id)
    {
        try {
            // find the data
            $query = Sales::findOrFail($id);

            // update to database
            $query->update(($request->validated() + [
                'name' => $request->name,
            ]));

            // activity log
            activity('updated')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new SalesResource($query), 'Changes has been successfully saved.');
        } catch (\Exception $e) {
            //return $e->getMessage();
            return response()->json(['success' => false, 'message' => 'An error occurred. Data failed to update!'], 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find data
        $query = Sales::findOrFail($id);
        $query->delete();
        $query->save();

        // activity log
        activity('deleted')
            ->performedOn($query)
            ->causedBy(Auth::user());

        // return JSON response
        return $this->successResponse(new SalesResource($query), $query->name . ' has been deleted successfully.');
    }
}
