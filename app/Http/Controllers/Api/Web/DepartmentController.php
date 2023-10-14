<?php

namespace App\Http\Controllers\API\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;
// use resource
use App\Http\Resources\Department\DepartmentCollection;
use App\Http\Resources\Department\DepartmentResource;
// model
use App\Models\MasterData\Department;
// request
use App\Http\Requests\Department\StoreDepartmentRequest;
use App\Http\Requests\Department\UpdateDepartmentRequest;

class DepartmentController extends Controller
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

        //set condition if search not empty then search by name
        if (!empty($search)) {
            $query = Department::where('name', 'like', '%' . $search . '%')
                ->paginate(
                    $perPage,
                    ['*'],
                    'page',
                    $page
                );

            //check result
            $recordsTotal = $query->count();
            if (empty($recordsTotal)) {
                return response(['Message' => 'Data not found!'], 404);
            }
        } else {
            // get department data and sort by name ascending
            $query = Department::orderBy('name', 'asc')->paginate($perPage, ['*'], 'page', $page);
        }

        // request by id then show detail data, not array
        if ($request->has('id')) {
            $id = $request->input('id');

            // find the data by id
            $query = Department::findOrFail($id);

            //return JSON response
            return $this->successResponse(new DepartmentResource($query), 'Data found.');
        }

        //return resource collection
        return new DepartmentCollection(true, 'Department retrieved successfully', $query);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        try {
            //store to database
            $query = Department::create([
                'name' => $request->name,
                'payroll_type' => $request->payroll_type,
                'is_has_schedule' => $request->is_has_schedule,
                'clock_in' => $request->clock_in,
                'clock_out' => $request->clock_out,
                'created_by' => Auth::user()->id,
            ] + $request->validated());

            // activity log
            activity('created')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new DepartmentResource($query), $query->name . ' has been created successfully.');
        } catch (\Throwable $th) {
            return $this->errorResponse('Data failed to save. Please try again!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, $id)
    {
        try {
            // find the data by ID
            $query = Department::findOrFail($id);

            // update to database
            $query->update(($request->validated() + [
                'name' => $request->name,
                'payroll_type' => $request->payroll_type,
                'is_has_schedule' => $request->is_has_schedule,
                'clock_in' => $request->clock_in,
                'clock_out' => $request->clock_out,
                'updated_by' => Auth::user()->id,
            ]));

            // activity log
            activity('updated')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new DepartmentResource($query), 'Changes has been successfully saved.');
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'An error occurred. Data failed to update!'], 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find data by ID
        $query = Department::findOrFail($id);
        $query->delete();
        // soft delete to database
        $query->deleted_by = Auth::user()->id;
        $query->save();

        // activity log
        activity('deleted')
            ->performedOn($query)
            ->causedBy(Auth::user());

        // return JSON response
        return $this->successResponse(new DepartmentResource($query), $query->name . ' has been deleted successfully.');
    }
}
