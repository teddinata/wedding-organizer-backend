<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\MasterData\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use App\Http\Controllers\Controller;
use App\Http\Resources\Resource;
use App\Http\Requests\Position\StorePositionRequest;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd('test');
        // get all positions with filter and pagination
        $query = Position::query();


        // filter by name
        if (request()->has('name')) {
            $query->where('name', 'like', '%' . request('name') . '%');
        }

        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // Get data
        $positions = $query->paginate($perPage, ['*'], 'page', $page);

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' show data Position',
            'description' => 'User ' . Auth::user()->name . ' show data Position',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return new Resource(true, 'Positions retrieved successfully', $positions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePositionRequest $request)
    {
        // create new position
        $position = Position::create([
            'name' => $request->name,
            'department_id' => $request->department_id,
            'created_by' => Auth::user()->id,
        ] + $request->validated());

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' create data Position',
            'description' => 'User ' . Auth::user()->name . ' create data Position',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return new Resource(true, 'Position created successfully', $position);
    }

    /**
     * Display the specified resource.
     */
    public function show(Position $position)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Position $position)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePositionRequest $request, Position $position)
    {
        // update position
        $position->update([
            'name' => $request->name,
            'department_id' => $request->department_id,
            'updated_by' => Auth::user()->id,
        ] + $request->validated());

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update data Position ' . $position->name,
            'description' => 'User ' . Auth::user()->name . ' update data Position ' . $position->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return new Resource(true, 'Position updated successfully', $position);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find position by id
        $position = Position::findOrFail($id);

        // delete position
        $position->delete();
        $position->deleted_by = Auth::user()->id;
        $position->save();

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete data Position ' . $position->name,
            'description' => 'User ' . Auth::user()->name . ' delete data Position ' . $position->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return new Resource(true, 'Position deleted successfully', $position);
    }
}
