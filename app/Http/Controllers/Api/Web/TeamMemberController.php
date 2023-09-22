<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\MasterData\Team;
use App\Models\MasterData\TeamMember;
use App\Http\Requests\TeamMember\StoreTeamMemberRequest;
use App\Http\Requests\TeamMember\UpdateTeamMemberRequest;
use App\Http\Resources\TeamResource;

class TeamMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreTeamMemberRequest $request)
    {
        $employee_ids = $request->employee_id;
        // dd($employee_ids);

        // pengecekan apakah employee_id sudah ada di team
        foreach ($employee_ids as $employee_id) {
            $teamMember = TeamMember::where('team_id', $request->team_id)->where('employee_id', $employee_id)->first();
            if ($teamMember) {
                return response()->json(['message' => 'Member have already in this team'], 422);
            } else {
                $teamMember = TeamMember::create([
                    'team_id' => $request->team_id,
                    'employee_id' => $employee_id,
                    // 'created_by' => auth()->user()->id,
                ]);
            }
        }

        $teamMember = TeamMember::where('id', $teamMember->id)->with('employee')->first();

        // return response
        return new TeamResource(true, 'Team Member created successfully', $teamMember);
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
    public function update(UpdateTeamMemberRequest $request, string $id)
    {
        // update team member like store function
        $teamMember = TeamMember::find($id);
        $employee_ids = $request->employee_id;
        foreach ($employee_ids as $employee_id) {

            // pengecekan data employee_id sudah ada di team berdasarkan id
            $teamMember = TeamMember::where('team_id', $request->team_id)->where('employee_id', $employee_id)->find($id);
            if ($teamMember) {
                return response()->json(['message' => 'Member have already in this team'], 422);
            } else {
                $teamMember = TeamMember::create([
                    'team_id' => $request->team_id,
                    'employee_id' => $employee_id,
                    // 'created_by' => auth()->user()->id,
                ]);
            }
        }

        // get team member updated
        $teamMember = TeamMember::where('id', $teamMember->id)->with('employee')->find($id);

        // return response
        return new TeamResource(true, 'Team Member updated successfully', $teamMember);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
