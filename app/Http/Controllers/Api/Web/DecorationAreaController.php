<?php

namespace App\Http\Controllers\API\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\DecorationArea\StoreAreaRequest;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
// use resource
use App\Http\Resources\DecorationAreaResource;
// model
use App\Models\MasterData\DecorationArea;

class DecorationAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // get area data and sort by name ascending
        $query = DecorationArea::orderBy('name', 'asc')->paginate($perPage, ['*'], 'page', $page);

        //return collection of area as a resource
        return new DecorationAreaResource(true, 'Area retrieved successfully', $query);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAreaRequest $request)
    {
        //store to database
        $query = DecorationArea::create([
            'name' => $request->name,
            'created_by' => Auth::user()->id,
        ] + $request->validated());

        // activity log
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' Create data area ' . $query->name,
            'description' => 'User ' . Auth::user()->name . ' Create data area ' . $query->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now()
        ]);

        // return json response
        return new DecorationAreaResource(true, $query->name . ' has been created successfully', $query);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // find the data by id
        $query = DecorationArea::findOrFail($id);

        //return single post as a resource
        return new DecorationAreaResource(true, 'Area decoration found!', $query);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
