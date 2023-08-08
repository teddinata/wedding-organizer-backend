<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\MembershipBenefit;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class MembershipBenefitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all membership benefits with filter and pagination
        $query = MembershipBenefit::query();

        // filter by name
        if (request()->has('description')) {
            $query->where('description', 'like', '%' . request('description') . '%');
        }

        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // Get data
        $membership_benefits = $query->paginate($perPage, ['*'], 'page', $page);

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' show data Membership Benefit',
            'description' => 'User ' . Auth::user()->name . ' show data Membership Benefit',
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
            'message' => 'Membership Benefits retrieved successfully.',
            'data' => $membership_benefits
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
        // validate incoming request
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
            'membership_id' => 'required|integer',
        ]);

        // create membership benefit
        $membership_benefit = MembershipBenefit::create([
            'image' => $request->image,
            'description' => $request->description,
            'membership_id' => $request->membership_id,
            'created_at' => now(),
            'created_by' => Auth::user()->id,
        ]);

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' store data Membership Benefit',
            'description' => 'User ' . Auth::user()->name . ' store data Membership Benefit',
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
            'message' => 'Membership Benefit saved successfully.',
            'data' => $membership_benefit
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(MembershipBenefit $membershipBenefit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MembershipBenefit $membershipBenefit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MembershipBenefit $membershipBenefit)
    {
        // validate incoming request
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
            'membership_id' => 'required|integer',
        ]);

        // update membership benefit
        $membership_benefit = $membershipBenefit->update([
            'image' => $request->image,
            'description' => $request->description,
            'membership_id' => $request->membership_id,
            'updated_by' => Auth::user()->id,
        ]);

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update data Membership Benefit',
            'description' => 'User ' . Auth::user()->name . ' update data Membership Benefit',
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
            'message' => 'Membership Benefit updated successfully.',
            'data' => $membership_benefit
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find membership benefit
        $membership_benefit = MembershipBenefit::find($id);

        // delete membership benefit
        $membership_benefit->delete();

        // deleted by
        $membership_benefit->deleted_by = Auth::user()->id;
        $membership_benefit->save();

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete data Membership Benefit',
            'description' => 'User ' . Auth::user()->name . ' delete data Membership Benefit',
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
            'message' => 'Membership Benefit deleted successfully.',
            'data' => $membership_benefit
        ], 200);
    }
}
