<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use App\Models\Operational\Vendor;
use App\Models\User;
use App\Http\Resources\VendorResource;
use App\Http\Requests\Vendor\StoreVendorRequest;
use App\Http\Requests\Vendor\UpdateVendorRequest;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all vendor with filter and paginate
        $query = Vendor::orderBy('name', 'asc');

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
        // count total vendor without paginate
        $totalData = $query->count();
        // count data vendors->is_first_login === 0
        $totalUserApp = $query->where('is_first_login', 0)->count();

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
            'message' => 'Vendors retrieved successfully',
            'total_data' => $totalData,
            'total_user_use_app' => $totalUserApp,
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
    public function store(StoreVendorRequest $request)
    {
        // create data vendor
        $vendor = Vendor::create([
            'vendor_grade_id' => $request->vendor_grade_id,
            'vendor_limit_id' => $request->vendor_limit_id,
            'membership_id' => $request->membership_id,
            'code' => $request->code,
            'name' => $request->name,
            'point' => $request->point,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'contact_person' => $request->contact_person,
            'website' => $request->website,
            'instagram' => $request->instagram,
            'address' => $request->address,
            'city' => $request->city,
            'created_by' => Auth::user()->id,
        ] + $request->validated());

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

        return new VendorResource(true, 'Vendor created successfully', $vendor);
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
    public function update(UpdateVendorRequest $request, string $id)
    {
        // dd($vendorGrade);
        // update data vendor
        $vendor = Vendor::findOrFail($id)->update([
            'vendor_grade_id' => $request->vendor_grade_id,
            'vendor_limit_id' => $request->vendor_limit_id,
            'membership_id' => $request->membership_id,
            'email' => $request->email,
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
        ] + $request->validated());

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

        return new VendorResource(true, 'Vendor updated successfully', $vendor);
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

        // deleted by
        $vendor->deleted_by = Auth::user()->id;
        $vendor->save();

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

        return new VendorResource(true, 'Vendor deleted successfully', $vendor);
    }
}
