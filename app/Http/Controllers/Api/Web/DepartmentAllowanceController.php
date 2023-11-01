<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;
// use resource
use App\Http\Resources\DepartmentAllowance\DepartmentAllowanceResource;
// use model
use App\Models\MasterData\Allowance;
use App\Models\MasterData\DepartmentAllowance;
// request
use App\Http\Requests\DepartmentAllowance\StoreDepartmentAllowanceRequest;
use App\Http\Requests\DepartmentAllowance\UpdateDepartmentAllowanceRequest;

class DepartmentAllowanceController extends Controller
{
    // use traits for success and error JSON response
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentAllowanceRequest $request)
    {
        $allowance_ids = $request->allowance_id;

        // check if allowance has been added or not
        foreach ($allowance_ids as $allowance_id) {
            $deptAllowance = DepartmentAllowance::where('department_id', $request->department_id)->where('allowance_id', $allowance_id)->first();
            if ($deptAllowance) {
                return response()->json(['message' => 'Allowance have already in this department'], 422);
            } else {
                $deptAllowance = DepartmentAllowance::create([
                    'department_id' => $request->department_id,
                    'allowance_id' => $allowance_id,
                    'created_by' => auth()->user()->id,
                ]);
            }
        }

        // activity log
        activity('created')
            ->performedOn($deptAllowance)
            ->causedBy(Auth::user());

        $deptAllowance = DepartmentAllowance::where('id', $deptAllowance->id)->with('allowance')->first();

        // return json response
        return $this->successResponse(new DepartmentAllowanceResource($deptAllowance), 'Department Allowance has been added successfully to this department,');
    }

    /**
     * Display the specified resource.
     */
    public function show(Allowance $allowance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentAllowanceRequest $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find allowance
        $query = DepartmentAllowance::findOrFail($id);
        $query->delete();
        // deleted by
        $query->deleted_by = Auth::user()->id;
        $query->save();

        // activity log
        activity('deleted')
            ->performedOn($query)
            ->causedBy(Auth::user());

        // return JSON response
        return $this->successResponse(new DepartmentAllowanceResource($query), 'Allowance has been removed successfully.');
    }
}
