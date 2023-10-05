<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use App\Traits\ApiResponseTrait;
// use resource
use App\Http\Resources\ChecklistItem\ChecklistItemCollection;
use App\Http\Resources\ChecklistItem\ChecklistItemResource;
// use model
use App\Models\MasterData\ChecklistItem;
// use request
use App\Http\Requests\ChecklistItem\StoreChecklistItemRequest;
use App\Http\Requests\ChecklistItem\UpdateChecklistItemRequest;

class ChecklistItemController extends Controller
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
            $query = ChecklistItem::where('name', 'like', '%' . $search . '%')->with(['checklist_category'])->paginate($perPage, ['*'], 'page', $page);

            //check result
            $recordsTotal = $query->count();
            if (empty($recordsTotal)) {
                return response(['Message' => 'Data not found!'], 404);
            }
        } else {
            // get checklist item data and sort by name ascending
            $query = ChecklistItem::with(['checklist_category'])->orderBy('name', 'asc')->paginate($perPage, ['*'], 'page', $page);
        }

        // return json response
        return new ChecklistItemCollection(true, 'Checklist items retrieved successfully', $query);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChecklistItemRequest $request)
    {
        try {
            //store to database
            $query = ChecklistItem::create([
                'name' => $request->name,
                'checklist_category_id' => $request->checklist_category_id,
                'created_by' => Auth::user()->id,
            ] + $request->validated());

            // activity log
            activity('created')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new ChecklistItemResource($query), $query->name . ' has been created successfully.');
        } catch (\Throwable $th) {
            return $this->errorResponse('Data failed to save. Please try again!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChecklistItemRequest $request, $id)
    {
        try {
            // find the data
            $query = ChecklistItem::findOrFail($id);

            // update to database
            $query->update(($request->validated() + [
                'name' => $request->name,
                'checklist_category_id' => $request->checklist_category_id,
                'updated_by' => Auth::user()->id,
            ]));

            // activity log
            activity('updated')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new ChecklistItemResource($query), 'Changes has been successfully saved.');
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'An error occurred. Data failed to update!'], 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find data by id
        $query = ChecklistItem::findOrFail($id);
        $query->delete();
        // deleted by
        $query->deleted_by = Auth::user()->id;
        $query->save();

        // activity log
        activity('deleted')
            ->performedOn($query)
            ->causedBy(Auth::user());

        // return json response
        return $this->successResponse(new ChecklistItemResource($query), $query->name . ' has been deleted successfully.');
    }
}
