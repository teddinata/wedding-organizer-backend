<?php

namespace App\Http\Controllers\Api\Web;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
// resource
use App\Http\Resources\EmployeeLevel\EmployeeLevelCollection;
use App\Http\Resources\EmployeeLevel\EmployeeLevelResource;
// model
use App\Models\MasterData\Level;
// request
use App\Http\Requests\Level\StoreLevelRequest;
use App\Http\Requests\Level\UpdateLevelRequest;


class LevelController extends Controller
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
            $query = Level::where('name', 'like', '%' . $search . '%')->paginate($perPage, ['*'], 'page', $page);

            //check result
            $recordsTotal = $query->count();
            if (empty($recordsTotal)) {
                return response(['Message' => 'Data not found!'], 404);
            }
        } else {
            // get checklist item data and sort by name ascending
            $query = Level::orderBy('from', 'asc')->paginate($perPage, ['*'], 'page', $page);
        }

        // foreach icon
        foreach ($query as $level) {
            $level->icon = asset('storage/uploads/level/' . $level->icon);
        }

        // return json response
        return new EmployeeLevelCollection(true, 'Level retrieved successfully', $query);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLevelRequest $request)
    {
        try {
            //store to database
            $query = Level::create([
                'name' => $request->name,
                'from' => $request->from,
                'until' => $request->until,
                'created_by' => Auth::user()->id,
            ] + $request->validated());

            // check if request has icon
            //if ($request->hasFile('icon')) {
            //$icon = $request->file('icon');
            //$filename = 'level' . '_' . rand(100000, 999999) . '_' . str_replace(' ', '_', $icon->getClientOriginalName());

            //$path = $icon->storeAs('uploads/level', $filename, 'public');

            //if ($path) {
            //$level['icon'] = $filename;
            //}
            //}
            // activity log
            activity('created')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new EmployeeLevelResource($query), $query->name . ' has been created successfully.');
        } catch (\Throwable $th) {
            return $this->errorResponse('Data failed to save. Please try again!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Level $level)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLevelRequest $request, $id)
    {
        try {
            // find the data
            $query = Level::findOrFail($id);

            // update level
            $query->update(($request->validated() + [
                'name' => $request->name,
                'from' => $request->from,
                'until' => $request->until,
                'updated_by' => Auth::user()->id,
            ]));

            // activity log
            activity('updated')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new EmployeeLevelResource($query), 'Changes has been successfully saved.');
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'An error occurred. Data failed to update!'], 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find level
        $query = Level::findOrFail($id);
        $query->delete();
        // deleted by
        $query->deleted_by = Auth::user()->id;
        $query->save();

        // activity log
        activity('deleted')
            ->performedOn($query)
            ->causedBy(Auth::user());

        // return json response
        return $this->successResponse(new EmployeeLevelResource($query), $query->name . ' has been deleted successfully.');
    }
}
