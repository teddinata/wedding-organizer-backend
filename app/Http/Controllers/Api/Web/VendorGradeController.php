<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use App\Models\VendorGrade;

class VendorGradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get all vendor grade with filter and paginate
        $query = VendorGrade::query();

        if (request('search')) {
            $query->where('name', 'like', '%' . request('search') . '%');
        }

        // request sort asc or desc
        if (request('sort')) {
            $query->orderBy('name', request('sort'));
        }

        // request by id then show detail data, not array
        if ($request->has('id')) {
            $id = $request->input('id');
            $vendor_grade = $query->findOrFail($id);

            Activity::create([
                'log_name' => 'User ' . Auth::user()->name . ' show data vendor grade detail ' . $vendor_grade->name,
                'description' => 'User ' . Auth::user()->name . ' show data vendor grade detail ' . $vendor_grade->name,
                'subject_id' => Auth::user()->id,
                'subject_type' => 'App\Models\User',
                'causer_id' => Auth::user()->id,
                'causer_type' => 'App\Models\User',
                'properties' => request()->ip(),
                // 'host' => request()->ip(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Detail Data Vendor Grade by id ' . $id,
                'data' => $vendor_grade
            ], 200);
        }

        // Get pagination settings
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        // Get data
        $vendor_grade = $query->paginate($perPage, ['*'], 'page', $page);

        // Log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' show data vendor grade',
            'description' => 'User ' . Auth::user()->name . ' show data vendor grade',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'List Data Vendor Grade',
            'data' => $vendor_grade
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate request
        $request->validate([
            'name' => 'required|unique:vendor_grades,name',
            'description' => 'required',
        ]);

        // create vendor grade
        $vendor_grade = VendorGrade::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);

        // Log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' create data vendor grade ' . $vendor_grade->name,
            'description' => 'User ' . Auth::user()->name . ' create data vendor grade ' . $vendor_grade->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vendor Grade has been successfully created!',
            'data' => $vendor_grade
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validate request
        $request->validate([
            'name' => 'required|unique:vendor_grades,name,' . $id,
            'description' => 'required',
        ]);

        // find vendor grade by id
        $vendor_grade = VendorGrade::findOrFail($id);

        // update vendor grade
        $vendor_grade->update([
            'name' => $request->name,
            'description' => $request->description,
            'updated_by' => Auth::user()->id,
        ]);

        // Log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update data vendor grade ' . $vendor_grade->name,
            'description' => 'User ' . Auth::user()->name . ' update data vendor grade ' . $vendor_grade->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vendor Grade has been successfully updated!',
            'data' => $vendor_grade
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // find vendor grade by id
        $vendor_grade = VendorGrade::findOrFail($id);

        // delete vendor grade
        $vendor_grade->delete();

        // Log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete data vendor grade ' . $vendor_grade->name,
            'description' => 'User ' . Auth::user()->name . ' delete data vendor grade ' . $vendor_grade->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vendor Grade has been successfully deleted!',
            'data' => $vendor_grade
        ], 200);
    }
}
