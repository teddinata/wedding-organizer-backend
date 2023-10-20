<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;
// use resource
use App\Http\Resources\Position\PositionCollection;
use App\Http\Resources\Position\PositionResource;
// model
use App\Models\MasterData\Position;
// request
use App\Http\Requests\Position\StorePositionRequest;

class PositionController extends Controller
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
            $query = Position::where('name', 'like', '%' . $search . '%')->with(['department', 'career_level'])->paginate($perPage, ['*'], 'page', $page);
        } else {
            // get position employee data and sort by name ascending
            $query = Position::with(['department', 'career_level'])->orderBy('name', 'asc')->paginate($perPage, ['*'], 'page', $page);
        }

        //return resource collection
        return new PositionCollection(true, 'Employee position retrieved successfully', $query);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePositionRequest $request)
    {
        try {
            // create new position
            $query = Position::create([
                'department_id' => $request->department_id,
                'career_level_id' => $request->career_level_id,
                'name' => $request->name,
            ] + $request->validated());

            // activity log
            activity('created')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new PositionResource($query), $query->name . ' has been created successfully.');
        } catch (\Throwable $th) {
            return $this->errorResponse('Data failed to save. Please try again!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Position $query)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePositionRequest $request, $id)
    {
        try {
            // find the data
            $query = Position::findOrFail($id);

            // update position
            $query->update([
                'department_id' => $request->department_id,
                'career_level_id' => $request->career_level_id,
                'name' => $request->name,
            ] + $request->validated());

            // activity log
            activity('updated')
                ->performedOn($query)
                ->causedBy(Auth::user());
            // return JSON response
            return $this->successResponse(new PositionResource($query), 'Changes has been successfully saved.');
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'An error occurred. Data failed to update!'], 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find position by id
        $query = Position::findOrFail($id);
        $query->delete();
        $query->save();

        // activity log
        activity('deleted')
            ->performedOn($query)
            ->causedBy(Auth::user());

        // return JSON response
        return $this->successResponse(new PositionResource($query), $query->name . ' has been deleted successfully.');
    }
}
