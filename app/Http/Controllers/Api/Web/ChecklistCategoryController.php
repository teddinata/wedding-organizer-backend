<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;
// use resource
use App\Http\Resources\ChecklistCategory\ChecklistCategoryCollection;
use App\Http\Resources\ChecklistCategory\ChecklistCategoryResource;
// use model
use App\Models\MasterData\ChecklistCategory;
// request
use App\Http\Requests\ChecklistCategory\StoreChecklistCategoryRequest;
use App\Http\Requests\ChecklistCategory\UpdateChecklistCategoryRequest;

class ChecklistCategoryController extends Controller
{
    // use traits for success and error JSON response
    use ApiResponseTrait;

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

        //return resource collection
        $showData = new ChecklistCategoryCollection(true, 'Checklist category retrieved successfully', $query);
        return  $showData->paginate($perPage, $page);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChecklistCategoryRequest $request)
    {
        try {
            //store to database
            $query = ChecklistCategory::create([
                'name' => $request->name,
            ] + $request->validated());

            // activity log
            activity('created')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return json response
            return $this->successResponse(new ChecklistCategoryResource($query), $query->name . ' has been created successfully.');
        } catch (\Throwable $th) {
            return $this->errorResponse('Data failed to save. Please try again!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChecklistCategoryRequest $request, $id)
    {
        try {
            // find the data by id
            $query = ChecklistCategory::findOrFail($id);

            // update to database
            $query->update(($request->validated() + [
                'name' => $request->name,
            ]));

            // activity log
            activity('updated')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return json response
            return $this->successResponse(new ChecklistCategoryResource($query), 'Changes has been successfully saved.');
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'An error occurred. Data failed to update!'], 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
