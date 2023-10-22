<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $query = ChecklistItem::where('name', 'like', '%' . $search . '%')->with(['checklist_category'])->get();
        } else {
            // get checklist item data and sort by name ascending
            $query = ChecklistItem::with(['checklist_category'])->orderBy('name', 'asc')->get();
        }

        //return resource collection
        $showData = new ChecklistItemCollection(true, 'Checklist items retrieved successfully', $query);
        return  $showData->paginate($perPage, $page);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChecklistItemRequest $request)
    {
        try {
            //store to database
            $query = ChecklistItem::create([
                'checklist_category_id' => $request->checklist_category_id,
                'name' => $request->name,
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
                'checklist_category_id' => $request->checklist_category_id,
                'name' => $request->name,
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
        $query->save();

        // activity log
        activity('deleted')
            ->performedOn($query)
            ->causedBy(Auth::user());

        // return json response
        return $this->successResponse(new ChecklistItemResource($query), $query->name . ' has been deleted successfully.');
    }
}
