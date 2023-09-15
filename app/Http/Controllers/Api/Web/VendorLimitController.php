<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
// use resource
use App\Http\Resources\VendorLimitResource;
// model
use App\Models\MasterData\VendorLimit;
// request
use App\Http\Requests\VendorLimit\StoreVendorLimitRequest;
use App\Http\Requests\VendorLimit\UpdateVendorLimitRequest;


class VendorLimitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get all vendor limit with filter and paginate
        $limit = VendorLimit::orderBy('id', 'asc')->paginate(10);

        if (request('search')) {
            $limit->where('name', 'like', '%' . request('search') . '%');
        }

        // request sort asc or desc
        if (request('sort')) {
            $limit->orderBy('name', request('sort'));
        }

        // request by id then show detail data, not array
        if ($request->has('id')) {
            $id = $request->input('id');
            $vendor_limit = $limit->findOrFail($id);

            Activity::create([
                'log_name' => 'User ' . Auth::user()->name . ' show data vendor limit detail ' . $vendor_limit->name,
                'description' => 'User ' . Auth::user()->name . ' show data vendor limit detail ' . $vendor_limit->name,
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
                'message' => 'Detail Data Vendor Limit by id ' . $id,
                'data' => $vendor_limit
            ], 200);
        }

        return new VendorLimitResource(true, 'Limit retrieved successfully', $limit);

         Activity::create([
             'log_name' => 'User ' . Auth::user()->name . ' show data vendor limit',
             'description' => 'User ' . Auth::user()->name . ' show data vendor limit',
             'subject_id' => Auth::user()->id,
             'subject_type' => 'App\Models\User',
             'causer_id' => Auth::user()->id,
             'causer_type' => 'App\Models\User',
             'properties' => request()->ip(),
             // 'host' => request()->ip(),
             'created_at' => now(),
             'updated_at' => now()
         ]);
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
    public function store(StoreVendorLimitRequest $request)
    {
        // create vendor limit
        $vendor_limit = VendorLimit::create([
            'name' => $request->name,
            'amount_limit' => $request->amount_limit,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ] + $request->validated());

        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' create data vendor limit ' . $vendor_limit->name,
            'description' => 'User ' . Auth::user()->name . ' create data vendor limit ' . $vendor_limit->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return new VendorLimitResource(true, $vendor_limit->name . ' has successfully been created.', $vendor_limit);
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

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVendorLimitRequest $request, string $id)
    {
        // get vendor limit by id
        $vendor_limit = VendorLimit::findOrFail($id);

        // update vendor limit
        $vendor_limit->update([
            'name' => request('name'),
            'amount_limit' => request('amount_limit'),
            'updated_by' => Auth::user()->id,
        ] + $request->validated());

        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' edit data vendor limit ' . $vendor_limit->name,
            'description' => 'User ' . Auth::user()->name . ' edit data vendor limit ' . $vendor_limit->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return new VendorLimitResource(true, $vendor_limit->name . ' has successfully been updated.', $vendor_limit);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // get vendor limit by id
        $vendor_limit = VendorLimit::findOrFail($id);

        // delete vendor limit
        $vendor_limit->delete();
        // updated deleted_by
        $vendor_limit->deleted_by = Auth::user()->id;
        $vendor_limit->save();

        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete data vendor limit ' . $vendor_limit->name,
            'description' => 'User ' . Auth::user()->name . ' delete data vendor limit ' . $vendor_limit->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return new VendorLimitResource(true, $vendor_limit->name . ' has successfully been deleted.', $vendor_limit);
    }
}
