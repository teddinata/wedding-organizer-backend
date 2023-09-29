<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
// use resource
use App\Http\Resources\ChecklistCategoryResource;
// use model
use App\Models\MasterData\ChecklistCategory;
// request
use App\Http\Requests\ChecklistCategory\StoreChecklistCategoryRequest;
use App\Http\Requests\ChecklistCategory\UpdateChecklistCategoryRequest;

class ChecklistCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // Get category data and sort by name ascending
        $query = ChecklistCategory::orderBy('name', 'asc')->paginate($perPage, ['*'], 'page', $page);

        // return json response
        return new ChecklistCategoryResource(true, 'Checklist Categories retrieved successfully', $query);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChecklistCategoryRequest $request)
    {
        //store to database
        $query = ChecklistCategory::create([
            'name' => $request->name,
        ] + $request->validated());

        // activity log
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' add checklist category',
            'description' => 'User ' . Auth::user()->name . ' create checklist category ' . $query->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now()
        ]);

        // return json response
        return new ChecklistCategoryResource(true, $query->name . ' has been created successfully', $query);
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
    public function update(UpdateChecklistCategoryRequest $request, $id)
    {
        // check the data by id
        $query = ChecklistCategory::findOrFail($id);

        // update to database
        $query->update(($request->validated() + [
            'name' => $request->name,
        ]));

        // activity log
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update checklist category',
            'description' => 'User ' . Auth::user()->name . ' update checklist category ' . $query->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return new ChecklistCategoryResource(true, $query->name . ' has successfully been updated.', $query);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
