<?php

namespace App\Http\Controllers\API\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
// use resource
use App\Http\Resources\DepartmentResource;
// model
use App\Models\MasterData\Department;
// request
use App\Http\Requests\Department\StoreDepartmentRequest;
use App\Http\Requests\Department\UpdateDepartmentRequest;

class DepartmentController extends Controller
{
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

        //set condition if search not empty then search by account_holder or account_number else then show all data
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
            // get bank account data and sort by account_holder ascending
            $query = Department::orderBy('name', 'asc')->paginate($perPage, ['*'], 'page', $page);
        }

        //return collection of department as a resource
        return new DepartmentResource(true, 'Department retrieved successfully', $query);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
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
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' add new department',
            'description' => 'User ' . Auth::user()->name . ' create new department ' . $query->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now()
        ]);

        // return json response
        return new DepartmentResource(true, $query->name . ' has successfully been created.', $query);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // find the data by ID
        $query = Department::findOrFail($id);

        //return single post as a resource
        return new DepartmentResource(true, 'Department found!', $query);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, $id)
    {
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
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update department information',
            'description' => 'User ' . Auth::user()->name . ' update department to ' . $query->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return new DepartmentResource(true, $query->name . ' has successfully been updated.', $query);
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
        Activity::create([
            'log_name' => 'Delete Data',
            'description' => 'User ' . Auth::user()->name . ' delete department ' . $query->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
        ]);

        // return json response
        return new DepartmentResource(true, $query->name . ' has successfully been deleted.', null);
    }
}
