<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\ChecklistItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class ChecklistItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all checklist items with filter and pagination
        $query = ChecklistItem::query();

        // filter by name
        if (request()->has('name')) {
            $query->where('name', 'like', '%' . request('name') . '%');
        }

        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // Get data
        $checklist_items = $query->paginate($perPage, ['*'], 'page', $page);

         // Log Activity
         Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' show data Checklist Item',
            'description' => 'User ' . Auth::user()->name . ' show data Checklist Item',
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
            'message' => 'Checklist Items retrieved successfully.',
            'data' => $checklist_items
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
        // validate incoming request
        $request->validate([
            'name' => 'required|string',
            'checklist_category_id' => 'required|exists:checklist_categories,id'
        ]);

        // create data
        $checklist_item = ChecklistItem::create([
            'name' => $request->name,
            'checklist_category_id' => $request->checklist_category_id,
            'created_by' => Auth::user()->id,
        ]);

        // Log Activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' store data Checklist Item',
            'description' => 'User ' . Auth::user()->name . ' store data Checklist Item',
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
            'message' => 'Checklist Item saved successfully.',
            'data' => $checklist_item
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(ChecklistItem $checklistItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChecklistItem $checklistItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChecklistItem $checklistItem)
    {
        // validate incoming request
        $request->validate([
            'name' => 'required|string' . $checklistItem->id,
            'checklist_category_id' => 'required|exists:checklist_categories,id'
        ]);

        // update data
        $checklistItem->update([
            'name' => $request->name,
            'checklist_category_id' => $request->checklist_category_id,
            'updated_by' => Auth::user()->id,
        ]);

        // Log Activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update data Checklist Item',
            'description' => 'User ' . Auth::user()->name . ' update data Checklist Item',
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
            'message' => 'Checklist Item updated successfully.',
            'data' => $checklistItem
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChecklistItem $checklistItem)
    {
        // find data by id
        $checklistItem = ChecklistItem::findOrFail($checklistItem->id);
        $checklistItem->delete();

        // Log Activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete data Checklist Item',
            'description' => 'User ' . Auth::user()->name . ' delete data Checklist Item',
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
            'message' => 'Checklist Item deleted successfully.',
            'data' => $checklistItem
        ], 200);
    }
}
