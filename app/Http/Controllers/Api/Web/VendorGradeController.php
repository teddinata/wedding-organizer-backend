<?php

namespace App\Http\Controllers\API\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
// use resource
use App\Http\Resources\VendorGradeResource;
// model
use App\Models\MasterData\VendorGrade;
// request
use App\Http\Requests\VendorGrade\StoreVendorGradeRequest;
use App\Http\Requests\VendorGrade\UpdateVendorGradeRequest;

class VendorGradeController extends Controller
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

        //set condition if search not empty then find by name else then show all data
        if (!empty($search)) {
            $query = VendorGrade::where('name', 'like', '%' . $search . '%')->paginate($perPage, ['*'], 'page', $page);

            //check result
            $recordsTotal = $query->count();
            if (empty($recordsTotal)) {
                return response(['Message' => 'Data not found!'], 404);
            }
        } else {
            // get grade data and sort by id ascending
            $query = VendorGrade::orderBy('id', 'asc')->paginate($perPage, ['*'], 'page', $page);
        }

        //return collection of grade vendor as a resource
        return new VendorGradeResource(true, 'Grade retrieved successfully', $query);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVendorGradeRequest $request)
    {
        //store to database
        $grade = VendorGrade::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => Auth::user()->id,
        ] + $request->validated());

        // activity log
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' add new grade',
            'description' => 'User ' . Auth::user()->name . ' create new grade ' . $grade->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now()
        ]);

        // return json response
        return new VendorGradeResource(true, $grade->name . ' has successfully been created.', $grade);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVendorGradeRequest $request, $id)
    {
        // find the data
        $grade = VendorGrade::findOrFail($id);

        // update to database
        $grade->update(($request->validated() + [
            'name' => $request->name,
            'description' => $request->description,
            'updated_by' => Auth::user()->id,
        ]));

        // activity log
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update grade information',
            'description' => 'User ' . Auth::user()->name . ' update grade information ' . $grade->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return new VendorGradeResource(true, $grade->name . ' has successfully been updated.', $grade);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find data
        $grade = VendorGrade::findOrFail($id);
        $grade->delete();
        // soft delete to database
        $grade->deleted_by = Auth::user()->id;
        $grade->save();

        // activity log
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete grade',
            'description' => 'User ' . Auth::user()->name . ' delete grade ' . $grade->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
        ]);

        // return json response
        return new VendorGradeResource(true, $grade->name . ' has successfully been deleted.', null);
    }
}
