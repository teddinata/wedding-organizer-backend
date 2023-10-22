<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;
// use resource
use App\Http\Resources\Vehicle\VehicleCollection;
use App\Http\Resources\Vehicle\VehicleResource;
// model
use App\Models\MasterData\Vehicle;
// request
use App\Http\Requests\Vehicle\StoreVehicleRequest;
use App\Http\Requests\Vehicle\UpdateVehicleRequest;


class VehicleController extends Controller
{
    // use traits for success and error JSON response format
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

        //set condition if search not empty then search by model_name or plate_number else then show all data
        if (!empty($search)) {
            $query = Vehicle::where('model_name', 'like', '%' . $search . '%')
                ->orWhere(
                    'plate_number',
                    'like',
                    '%' . $search . '%'
                )
                ->get();
        } else {
            // get config installment data and sort by nominal ascending
            $query = Vehicle::orderBy('model_name', 'asc')->get();
        }

        // request by id then show detail data, not array
        if ($request->has('id')) {
            $id = $request->input('id');

            // find the data by id
            $query = Vehicle::findOrFail($id);

            //return JSON response
            return $this->successResponse(new VehicleResource($query), 'Data found.');
        }

        //return resource collection
        $showData = new VehicleCollection(true, 'Vehicle retrieved successfully', $query);
        return  $showData->paginate($perPage, $page);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVehicleRequest $request)
    {
        try {
            //store to database
            $query = Vehicle::create([
                'model_name' => $request->model_name,
                'plate_number' => $request->plate_number,
            ] + $request->validated());

            // activity log
            activity('created')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new VehicleResource($query), $query->model_name . ' has been created successfully.');
        } catch (\Throwable $th) {
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
    public function update(UpdateVehicleRequest $request, string $id)
    {
        try {
            // find the data
            $query = Vehicle::findOrFail($id);

            // update to database
            $query->update(($request->validated() + [
                'model_name' => $request->model_name,
                'plate_number' => $request->plate_number,
            ]));

            // activity log
            activity('updated')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new VehicleResource($query), 'Changes has been successfully saved.');
        } catch (\Throwable $th) {
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
        $query = Vehicle::findOrFail($id);
        $query->delete();
        $query->save();

        // activity log
        activity('deleted')
            ->performedOn($query)
            ->causedBy(Auth::user());

        // return JSON response
        return $this->successResponse(new VehicleResource($query), $query->model_name . ' has been deleted successfully.');
    }
}
