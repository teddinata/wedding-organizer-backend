<?php

namespace App\Http\Controllers\API\Web;

use App\Http\Controllers\Controller;
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
    public function index()
    {
        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // get department data and sort by name ascending
        $department = Department::orderBy('name', 'asc')->paginate($perPage, ['*'], 'page', $page);
        //return collection of department as a resource

        // Log Activity
        Activity::create([
            'log_name' => 'Show Data',
            'description' => 'User ' . Auth::user()->name . ' Show department list',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return new DepartmentResource(true, 'Department retrieved successfully', $department);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        //store to database
        $department = Department::create([
            'name' => $request->name,
            'payroll_type' => $request->payroll_type,
            'is_has_schedule' => $request->is_has_schedule,
            'clock_in' => $request->clock_in,
            'clock_out' => $request->clock_out,
            'created_by' => Auth::user()->id,
        ] + $request->validated());

        // activity log
        Activity::create([
            'log_name' => 'Department Creation',
            'description' => 'User ' . Auth::user()->name . ' create department ' . $department->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now()
        ]);

        // return json response
        return new DepartmentResource(true, $department->name . ' has successfully been created.', $department);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $department = Department::findOrFail($id);
        //return single post as a resource
        return new DepartmentResource(true, 'Data Department Found!', $department);

        // activity log
        Activity::create([
            'log_name' => 'View Data',
            'description' => 'User ' . Auth::user()->name . ' view department ' . $department->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, $id)
    {
        // find the data
        $department = Department::findOrFail($id);

        // update to database
        $department->update(($request->validated() + [
            'name' => $request->name,
            'payroll_type' => $request->payroll_type,
            'is_has_schedule' => $request->is_has_schedule,
            'clock_in' => $request->clock_in,
            'clock_out' => $request->clock_out,
            'updated_by' => Auth::user()->id,
        ]));

        // activity log
        Activity::create([
            'log_name' => 'Update Data',
            'description' => 'User ' . Auth::user()->name . ' update department to ' . $department->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return new DepartmentResource(true, $department->name . ' has successfully been updated.', $department);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find data
        $department = Department::findOrFail($id);
        $department->delete();
        // soft delete to database
        $department->deleted_by = Auth::user()->id;
        $department->save();

        // activity log
        Activity::create([
            'log_name' => 'Delete Data',
            'description' => 'User ' . Auth::user()->name . ' delete department ' . $department->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
        ]);

        // return json response
        return new DepartmentResource(true, $department->name . ' has successfully been deleted.', null);
    }
}
