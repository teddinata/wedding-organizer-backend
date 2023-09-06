<?php

namespace App\Http\Controllers\API\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
// use resource
use App\Http\Resources\VehicleResource;
// model
use App\Models\MasterData\Vehicle;
// request
use App\Http\Requests\Vehicle\StoreVehicleRequest;
use App\Http\Requests\Vehicle\UpdateVehicleRequest;


class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get sales data and sort by name ascending
        $vehicle = Vehicle::orderBy('model_name', 'asc')->paginate(10);
        //return collection of sales as a resource
        return new VehicleResource(true, 'Vehicle retrieved successfully', $vehicle);

        // Log Activity
        Activity::create([
            'log_name' => 'Show Data',
            'description' => 'User ' . Auth::user()->name . ' Show vehicle list',
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
    public function store(StoreVehicleRequest $request)
    {
        //store to database
        $vehicle = Vehicle::create([
            'model_name' => $request->model_name,
            'plate_number' => $request->plate_number,
            'created_by' => Auth::user()->id,
        ] + $request->validated());

        // activity log
        Activity::create([
            'log_name' => 'Vehicle Creation',
            'description' => 'User ' . Auth::user()->name . ' create vehicle ' . $vehicle->model_name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now()
        ]);

        // return json response
        return new VehicleResource(true, $vehicle->model_name . ' has successfully been created.', $vehicle);
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
        // find the data
        $vehicle = Vehicle::findOrFail($id);

        // update to database
        $vehicle->update(($request->validated() + [
            'model_name' => $request->model_name,
            'plate_number' => $request->plate_number,
            'updated_by' => Auth::user()->id,
        ]));

        // activity log
        Activity::create([
            'log_name' => 'Update Data',
            'description' => 'User ' . Auth::user()->name . ' update vehicle to ' . $vehicle->model_name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return new VehicleResource(true, $vehicle->model_name . ' has successfully been updated.', $vehicle);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find data
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();
        // soft delete to database
        $vehicle->deleted_by = Auth::user()->id;
        $vehicle->save();

        // activity log
        Activity::create([
            'log_name' => 'Delete Data',
            'description' => 'User ' . Auth::user()->name . ' delete vehicle ' . $vehicle->model_name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
        ]);

        // return json response
        return new VehicleResource(true, $vehicle->model_name . ' has successfully been deleted.', null);
    }
}
