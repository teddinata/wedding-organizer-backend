<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\MasterData\MembershipBenefit;
use App\Models\MasterData\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use App\Http\Resources\MembershipBenefitResource;
use App\Http\Requests\MembershipBenefit\StoreMembershipBenefitRequest;
use App\Http\Requests\MembershipBenefit\UpdateMembershipBenefitRequest;

class MembershipBenefitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all membership benefits with filter and pagination
        $query = MembershipBenefit::orderBy('created_at', 'asc');

        // filter by name
        if (request()->has('search')) {
            $query->where('description', 'like', '%' . request('search') . '%');
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
        return new MembershipBenefitResource(true, 'Membership Benefits retrieved successfully', $membership_benefits);
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
    public function store(StoreMembershipBenefitRequest $request)
    {
        // create membership benefit
        $membership_benefit = [
            'description' => $request->input('description'),
            'membership_id' => $request->input('membership_id'),
            'created_by' => Auth::user()->id,
        ];

        // check if request has image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'membership_benefit' . '_' . rand(100000, 999999) . '_' . str_replace(' ', '_', $image->getClientOriginalName());

            $path = $image->storeAs('uploads/membership_benefit', $filename, 'public');

            if ($path) {
                $membership_benefit['image'] = $filename;
            }
        }

        // create membership benefit
        $membershipBenefit = MembershipBenefit::create($membership_benefit + $request->validated());

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
        return new MembershipBenefitResource(true, 'Membership Benefit created successfully', $membershipBenefit);

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
    public function update(UpdateMembershipBenefitRequest $request, MembershipBenefit $membershipBenefit)
    {
        // update membership benefit like store() method above
        $membershipData = [
            'description' => $request->input('description'),
            'membership_id' => $request->input('membership_id'),
            'updated_by' => Auth::user()->id,
        ];


        // check if request has image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'membership_benefit' . '_' . rand(100000, 999999) . '_' . str_replace(' ', '_', $image->getClientOriginalName());

            $path = $image->storeAs('uploads/membership_benefit', $filename, 'public');

            if ($path) {
                $membershipData['image'] = $filename;
            }
        }
        // dd($request->image);

        // update membership benefit
        $membershipBenefit->update($membershipData + $request->validated());

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
        return new MembershipBenefitResource(true, 'Membership Benefit updated successfully', $membershipBenefit);
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
        return new MembershipBenefitResource(true, 'Membership Benefit deleted successfully', null);
    }
}
