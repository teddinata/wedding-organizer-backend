<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\MasterData\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use App\Http\Resources\LevelResource;
use App\Http\Requests\Level\StoreLevelRequest;
use App\Http\Requests\Level\UpdateLevelRequest;


class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all levels with filter and pagination
        $level = Level::query();

        // filter by name
        if (request()->has('name')) {
            $level->where('name', 'like', '%' . request('name') . '%');
        }

        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // Get data
        $levels = $level->paginate($perPage, ['*'], 'page', $page);

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
        return new LevelResource(true, 'Level retrieved successfully', $levels);
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
    public function store(StoreLevelRequest $request)
    {
        // create new level
        $level = Level::create([
            'name' => $request->name,
            'icon' => $request->icon,
            'from' => $request->from,
            'until' => $request->until,
            'created_by' => Auth::user()->id,
        ] + $request->validated());

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
        return new LevelResource(true, 'Level created successfully', $level);
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
    public function update(UpdateLevelRequest $request, Level $level)
    {
        // update level
        $level->update([
            'name' => $request->name,
            'icon' => $request->icon,
            'from' => $request->from,
            'until' => $request->until,
            'updated_by' => Auth::user()->id,
        ] + $request->validated());

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
        return new LevelResource(true, 'Level updated successfully', $level);
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
        return new LevelResource(true, 'Level deleted successfully', $level);
    }
}
