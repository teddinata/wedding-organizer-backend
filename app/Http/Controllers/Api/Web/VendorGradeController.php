<?php

namespace App\Http\Controllers\API\Web;

use App\Http\Controllers\Controller;
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
    public function index()
    {
        // get sales data and sort by name ascending
        $grade = VendorGrade::orderBy('id', 'asc')->paginate(10);
        //return collection of sales as a resource
        return new VendorGradeResource(true, 'Grade retrieved successfully', $grade);

        // Log Activity
        Activity::create([
            'log_name' => 'Show Data',
            'description' => 'User ' . Auth::user()->name . ' Show grade list',
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
            'log_name' => 'Vendor Grade Creation',
            'description' => 'User ' . Auth::user()->name . ' create grade ' . $grade->name,
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
            'log_name' => 'Update Data',
            'description' => 'User ' . Auth::user()->name . ' update grade to ' . $grade->name,
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
            'log_name' => 'Delete Data',
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
