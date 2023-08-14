<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorLimit;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;


class VendorLimitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get all vendor limit with filter and paginate
        $query = VendorLimit::query();

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
            $vendor_limit = $query->findOrFail($id);

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

         // Get pagination settings
         $perPage = $request->input('per_page', 10);
         $page = $request->input('page', 1);

         // Get data
         $vendor_limit = $query->paginate($perPage, ['*'], 'page', $page);

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

         return response()->json([
             'success' => true,
             'message' => 'List Data Vendor Limit',
             'data' => $vendor_limit
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
    public function store(Request $request)
    {
        // validate request
        $request->validate([
            'name' => 'required',
            'amount_limit' => 'required|numeric',
        ]);

        // create vendor limit
        $vendor_limit = VendorLimit::create([
            'name' => $request->name,
            'amount_limit' => $request->amount_limit,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);

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

        return response()->json([
            'success' => true,
            'message' => 'Vendor Limit data saved successfully.',
            'data' => $vendor_limit
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

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // get vendor limit by id
        $vendor_limit = VendorLimit::findOrFail($id);

        // validate request
        request()->validate([
            'name' => 'required' . $id,
            'amount_limit' => 'required|numeric',
        ]);

        // update vendor limit
        $vendor_limit->update([
            'name' => request('name'),
            'amount_limit' => request('amount_limit'),
            'updated_by' => Auth::user()->id,
        ]);

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

        return response()->json([
            'success' => true,
            'message' => 'Vendor Limit data updated successfully.',
            'data' => $vendor_limit
        ], 200);
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
        $vendor_limit->update([
            'deleted_by' => Auth::user()->id,
        ]);

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

        return response()->json([
            'success' => true,
            'message' => 'Vendor Limit data deleted successfully.',
            'data' => $vendor_limit
        ], 200);
    }
}
