<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\MasterData\ChecklistItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use App\Http\Resources\ChecklistItemResource;
use App\Http\Requests\ChecklistItem\StoreChecklistItemRequest;
use App\Http\Requests\ChecklistItem\UpdateChecklistItemRequest;

class ChecklistItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all checklist items with filter and pagination
        $query = ChecklistItem::with(['checklist_category']);

        // filter by name
        if (request()->has('search')) {
            $query->where('name', 'like', '%' . request('search') . '%');
        }

        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // Get data
        $checklist_items = $query->paginate($perPage, ['*'], 'page', $page);

        // return json response
        return new ChecklistItemResource(true, 'Checklist Items retrieved successfully', $checklist_items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChecklistItemRequest $request)
    {
        // create data
        $checklist_item = ChecklistItem::create([
            'name' => $request->name,
            'checklist_category_id' => $request->checklist_category_id,
            'created_by' => Auth::user()->id,
        ] + $request->validated());

        // Log Activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' add checklist item',
            'description' => 'User ' . Auth::user()->name . ' create checklist item',
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
        return new ChecklistItemResource(true, $checklist_item->name .  'has successfully been created.', $checklist_item);
    }

    /**
     * Display the specified resource.
     */
    public function show(ChecklistItem $checklistItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChecklistItemRequest $request, ChecklistItem $checklistItem)
    {
        // update data
        $checklistItem->update([
            'name' => $request->name,
            'checklist_category_id' => $request->checklist_category_id,
            'updated_by' => Auth::user()->id,
        ]);

        // Log Activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update checklist item',
            'description' => 'User ' . Auth::user()->name . ' update checklist item' . $checklistItem->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return new ChecklistItemResource(true, $checklistItem->name . ' has successfully been updated.', $checklistItem);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChecklistItem $checklistItem)
    {
        // find data by id
        $checklistItem = ChecklistItem::findOrFail($checklistItem->id);
        $checklistItem->delete();
        // deleted by
        $checklistItem->deleted_by = Auth::user()->id;
        $checklistItem->save();

        // Log Activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete checklist item',
            'description' => 'User ' . Auth::user()->name . ' delete checklist item' . $checklistItem->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return new ChecklistItemResource(true, $checklistItem->name . ' has successfully been deleted.', $checklistItem);
    }
}
