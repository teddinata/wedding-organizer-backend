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

        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // Get data
        $membership_benefits = $query->paginate($perPage, ['*'], 'page', $page);

        // // log activity
        // Activity::create([
        //     'log_name' => 'User ' . Auth::user()->name . ' show data Membership Benefit',
        //     'description' => 'User ' . Auth::user()->name . ' show data Membership Benefit',
        //     'subject_id' => Auth::user()->id,
        //     'subject_type' => 'App\Models\User',
        //     'causer_id' => Auth::user()->id,
        //     'causer_type' => 'App\Models\User',
        //     'properties' => request()->ip(),
        //     // 'host' => request()->ip(),
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);

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
        $membership_ids = $request->membership_id;

        foreach ($membership_ids as $membership_id) {
            $membership_benefit = MembershipBenefit::where('membership_id', $membership_id)->where('benefit_id', $request->benefit_id)->first();
            if ($membership_benefit) {
                return response()->json(['message' => 'Membership has already had this benefit'], 422);
            } else {
                $membership_benefit = MembershipBenefit::create([
                    'benefit_id' => $request->benefit_id,
                    'membership_id' => $membership_id,
                    // 'created_by' => auth()->user()->id,
                ]);
            }
        }

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
        return new MembershipBenefitResource(true, 'Membership Benefit created successfully', $membership_benefit);

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
        $membership_benefit = $membershipBenefit;
        // dd($membership_benefit);
        $benefit_id = $membership_benefit->benefit_id;
        $membership_ids = $request->membership_id;

        // Ambil semua anggota tim yang ada dalam database untuk tim tertentu
        // $existing_team_members = TeamMember::where('team_id', $team_id)->get();
        $existing_membership_benefit = MembershipBenefit::where('membership_id', $membership_benefit->membership_id)->get();

        // Loop melalui anggota tim yang ada
        foreach ($existing_membership_benefit as $existing_member) {
            $membership_id = $existing_member->membership_id;

            // Jika employee_id tidak ada dalam daftar baru, hapus anggota tim tersebut
            if (!in_array($membership_id, $membership_ids)) {
                $existing_member->delete();
            }
        }

        // Tambahkan anggota tim baru
        foreach ($membership_ids as $membership_id) {
            // Periksa apakah anggota tim sudah ada dalam database
            $existing_member = MembershipBenefit::where('benefit_id', $benefit_id)->where('membership_id', $membership_id)->first();

            if (!$existing_member) {
                // Jika tidak ada, tambahkan anggota tim baru
                MembershipBenefit::create([
                    'benefit_id' => $benefit_id,
                    'membership_id' => $membership_id,
                ]);
            }
        }

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
        return new MembershipBenefitResource(true, 'Membership Benefit updated successfully', $membership_benefit);
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
