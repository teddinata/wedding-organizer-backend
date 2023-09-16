<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\MasterData\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use App\Http\Resources\MembershipResource;
use App\Http\Requests\Membership\StoreMembershipRequest;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all memberships with filter and pagination
        $query = Membership::orderBy('name', 'asc');

        // filter by name
        if (request()->has('search')) {
            $query->where('name', 'like', '%' . request('search') . '%');
        }

        // sort asc or desc
        if (request()->has('sort')) {
            $query->orderBy('name', request('sort'));
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
        return new MembershipResource(true, 'Memberships retrieved successfully', $memberships);
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
    public function store(StoreMembershipRequest $request)
    {
        // create new membership
        $membership = Membership::create([
            'name' => $request->name,
            'image' => $request->image,
            'from' => $request->from,
            'until' => $request->until,
            'point' => $request->point,
            'created_by' => Auth::user()->id,
        ] + $request->validated());

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
        return new MembershipResource(true, 'Membership created successfully', $membership);
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
    public function update(StoreMembershipRequest $request, Membership $membership)
    {
        // update membership
        $membership->update([
            'name' => $request->name,
            'image' => $request->image,
            'from' => $request->from,
            'until' => $request->until,
            'point' => $request->point,
            'updated_by' => Auth::user()->id,
        ] + $request->validated());

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
        return new MembershipResource(true, 'Membership updated successfully', $membership);
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
        return new MembershipResource(true, 'Membership deleted successfully', null);
    }
}
