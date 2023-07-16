<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use App\Models\VendorGrade;
use App\Models\VendorLimit;
use App\Models\Vendor;
use App\Models\User;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all vendor with filter and paginate
        $query = Vendor::query();

        if (request('search')) {
            $query->where('name', 'like', '%' . request('search') . '%');
        }

        // request sort asc or desc
        if (request('sort')) {
            $query->orderBy('name', request('sort'));
        }

        // request by id then show detail data, not array
        if (request('id')) {
            $id = request('id');
            $vendor = $query->findOrFail($id);

            Activity::create([
                'log_name' => 'User ' . Auth::user()->name . ' show data vendor detail ' . $vendor->name,
                'description' => 'User ' . Auth::user()->name . ' show data vendor detail ' . $vendor->name,
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
                'message' => 'Detail Data Vendor by id ' . $id,
                'data' => $vendor
            ], 200);
        }

        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // Get data vendor with paginate and relationship with vendor grade and vendor limit
        $vendors = $query->with(['vendor_grade', 'vendor_limit'])->paginate($perPage, ['*'], 'page', $page);

        // Log Activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' show data vendor',
            'description' => 'User ' . Auth::user()->name . ' show data vendor',
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
            'message' => 'List Data Vendor',
            'data' => $vendors
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
        // dd($request->all());
        // validate request
        $request->validate([
            'name' => 'required',
            'vendor_grade_id' => 'required',
            'vendor_limit_id' => 'required',
            'code' => 'required',
            'name' => 'required',
            // 'point' => 'required|numeric',
            // point integer
            'point' => 'required|integer',
            'contact_number' => 'required',
            'contact_person' => 'required',
            'website' => 'required',
            'instagram' => 'required',
            'address' => 'required',
            'city' => 'required',
        ]);

        // dd($vendorGrade);
        // $vendorGrade = VendorGrade::findOrFail($request->vendor_grade_id);

        // // // vendor limit
        // $vendorLimit = VendorLimit::findOrFail($request->vendor_limit_id);



        // create data vendor
        $vendor = Vendor::create([
            // 'vendor_grade_id' => $vendorGrade->id,
            // 'vendor_limit_id' => $vendorLimit->id,
            'vendor_grade_id' => $request->vendor_grade_id,
            'vendor_limit_id' => $request->vendor_limit_id,
            'code' => $request->code,
            'name' => $request->name,
            'point' => $request->point,
            'contact_number' => $request->contact_number,
            'contact_person' => $request->contact_person,
            'website' => $request->website,
            'instagram' => $request->instagram,
            'address' => $request->address,
            'city' => $request->city,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);


        // Log Activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' create data vendor ' . $vendor->name,
            'description' => 'User ' . Auth::user()->name . ' create data vendor ' . $vendor->name,
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
            'message' => 'Vendor has been successfully created!',
            'data' => $vendor
        ], 200);
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
        // dd($request->all());
        // validate request
        $request->validate([
            'name' => 'required',
            'vendor_grade_id' => 'required',
            'vendor_limit_id' => 'required',
            'code' => 'required',
            'name' => 'required',
            // 'point' => 'required|numeric',
            // point integer
            'point' => 'required|integer',
            'contact_number' => 'required',
            'contact_person' => 'required',
            'website' => 'required',
            'instagram' => 'required',
            'address' => 'required',
            'city' => 'required',
        ]);

        // dd($request->all());

        // dd($vendorGrade);
        // update data vendor
        $vendor = Vendor::findOrFail($id)->update([
            'vendor_grade_id' => $request->vendor_grade_id,
            'vendor_limit_id' => $request->vendor_limit_id,
            'code' => $request->code,
            'name' => $request->name,
            'point' => $request->point,
            'contact_number' => $request->contact_number,
            'contact_person' => $request->contact_person,
            'website' => $request->website,
            'instagram' => $request->instagram,
            'address' => $request->address,
            'city' => $request->city,
            'updated_by' => Auth::user()->id,
        ]);

        $vendor = Vendor::findOrFail($id);

        // Log Activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update data vendor ' ,
            'description' => 'User ' . Auth::user()->name . ' update data vendor ' ,
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
            'message' => 'Vendor has been successfully updated!',
            'data' => $vendor
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // get data vendor by id
        $vendor = Vendor::findOrFail($id);

        // delete data vendor
        $vendor->delete();

        // Log Activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete data vendor ' . $vendor->name,
            'description' => 'User ' . Auth::user()->name . ' delete data vendor ' . $vendor->name,
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
            'message' => 'Vendor has been successfully deleted!',
            'data' => $vendor
        ], 200);
    }
}
