<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\MasterData\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all memberships with filter and pagination
        $query = Membership::query();

        // filter by name
        if (request()->has('name')) {
            $query->where('name', 'like', '%' . request('name') . '%');
        }

        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // Get data
        $memberships = $query->paginate($perPage, ['*'], 'page', $page);

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' show data Membership',
            'description' => 'User ' . Auth::user()->name . ' show data Membership',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return response()->json([
            'success' => true,
            'message' => 'Memberships retrieved successfully.',
            'data' => $memberships
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
            'name' => 'required|string',
            'image' => 'nullable|string',
            'from' => 'required|integer',
            'until' => 'required|integer',
            'point' => 'required|integer',
        ]);
        // dd($request->all());

        // create new membership
        $membership = Membership::create([
            'name' => $request->name,
            'image' => $request->image,
            'from' => $request->from,
            'until' => $request->until,
            'point' => $request->point,
            'created_by' => Auth::user()->id,
        ]);

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' create data Membership ' . $membership->name,
            'description' => 'User ' . Auth::user()->name . ' create data Membership ' . $membership->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);



        // return json response
        return response()->json([
            'success' => true,
            'message' => 'Membership created successfully.',
            'data' => $membership
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Membership $membership)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Membership $membership)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Membership $membership)
    {
        // validate request
        $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|string',
            'from' => 'required|integer',
            'until' => 'required|integer',
            'point' => 'required|integer',
        ]);

        // update membership
        $membership->update([
            'name' => $request->name,
            'image' => $request->image,
            'from' => $request->from,
            'until' => $request->until,
            'point' => $request->point,
            'updated_by' => Auth::user()->id,
        ]);

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update data Membership ' . $membership->name,
            'description' => 'User ' . Auth::user()->name . ' update data Membership ' . $membership->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return response()->json([
            'success' => true,
            'message' => 'Membership updated successfully.',
            'data' => $membership
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find membership
        $membership = Membership::findOrFail($id);

        // delete membership
        $membership->delete();

        // deleted by
        $membership->update([
            'deleted_by' => Auth::user()->id,
        ]);

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete data Membership ' . $membership->name,
            'description' => 'User ' . Auth::user()->name . ' delete data Membership ' . $membership->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return response()->json([
            'success' => true,
            'message' => 'Membership deleted successfully.',
            'data' => $membership
        ], 200);
    }
}
