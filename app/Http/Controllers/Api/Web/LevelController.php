<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all levels with filter and pagination
        $query = Level::query();

        // filter by name
        if (request()->has('name')) {
            $query->where('name', 'like', '%' . request('name') . '%');
        }

        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // Get data
        $levels = $query->paginate($perPage, ['*'], 'page', $page);

        // logs
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' show data Level',
            'description' => 'User ' . Auth::user()->name . ' show data Level',
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
        return response()->json([
            'success' => true,
            'message' => 'Levels retrieved successfully.',
            'data' => $levels
        ], 200);
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
    public function store(Request $request)
    {
        // validate request
        $request->validate([
            'name' => 'required|unique:levels,name',
            'icon' => 'nullable|string',
            'from' => 'required|numeric',
            'until' => 'required|numeric',
        ]);

        // create new level
        $level = Level::create([
            'name' => $request->name,
            'icon' => $request->icon,
            'from' => $request->from,
            'until' => $request->until,
        ]);

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' store data Level',
            'description' => 'User ' . Auth::user()->name . ' store data Level',
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
        return response()->json([
            'success' => true,
            'message' => 'Level created successfully.',
            'data' => $level
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Level $level)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Level $level)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Level $level)
    {
        // validate request
        $request->validate([
            'name' => 'required|unique:levels,name,' . $level->id,
            'icon' => 'nullable|string',
            'from' => 'required|numeric',
            'until' => 'required|numeric',
        ]);

        // update level
        $level->update([
            'name' => $request->name,
            'icon' => $request->icon,
            'from' => $request->from,
            'until' => $request->until,
        ]);

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update data Level',
            'description' => 'User ' . Auth::user()->name . ' update data Level',
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
        return response()->json([
            'success' => true,
            'message' => 'Level updated successfully.',
            'data' => $level
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find level
        $level = Level::findOrFail($id);

        // delete level
        $level->delete();

        // deleted by
        $level->deleted_by = Auth::user()->id;
        $level->save();

        // logs
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete data Level',
            'description' => 'User ' . Auth::user()->name . ' delete data Level',
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
        return response()->json([
            'success' => true,
            'message' => 'Level deleted successfully.',
            'data' => $level
        ], 200);
    }
}
