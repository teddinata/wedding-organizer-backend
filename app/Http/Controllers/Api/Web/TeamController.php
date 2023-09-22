<?php

namespace App\Http\Controllers\API\Web;

use App\Actions\Jetstream\UpdateTeamName;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
// use resource
use App\Http\Resources\TeamResource;
// model
use App\Models\MasterData\Team;
use App\Models\MasterData\TeamLead;
use App\Models\MasterData\Employee;
use App\Models\User;
// request
use App\Http\Requests\Team\StoreTeamRequest;
use App\Http\Requests\Team\UpdateTeamRequest;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);
        // get team data and sort by name ascending with lead and member
        $team = Team::with('lead', 'member')->orderBy('name', 'asc')->paginate($perPage, ['*'], 'page', $page);
        //return collection of sales as a resource

        // Log Activity
        Activity::create([
            'log_name' => 'Show Data',
            'description' => 'User ' . Auth::user()->name . ' Show team list',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        return new TeamResource(true, 'Team retrieved successfully', $team);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request)
    {
        //store to database
        $team = Team::create([
            'name' => $request->name,
            'created_by' => Auth::user()->id,
        ] + $request->validated());

        // attach team lead
        $team->lead()->attach($request->lead);
        $team->save();

        $team_lead = TeamLead::with('employee')->where('team_id', $team->id)->get();

        // activity log
        Activity::create([
            'log_name' => 'Sales Creation',
            'description' => 'User ' . Auth::user()->name . ' create team ' . $team->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now()
        ]);

        // return json response team with lead data have been created
        return new TeamResource(true, $team->name . ' has successfully been created.', $team = [
            'team' => $team,
            'team_lead' => $team_lead
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeamRequest $request, string $id)
    {
        // find the data
        $team = Team::findOrFail($id);

        // update to database
        $team->update([
            'name' => $request->name,
            'updated_by' => Auth::user()->id,
        ] + $request->validated());

        // update team lead
        $team->lead()->sync($request->lead);
        $team->save();

        $team_lead = TeamLead::where('team_id', $team->id)->with('employee')->get();

        // activity log
        Activity::create([
            'log_name' => 'Update Data',
            'description' => 'User ' . Auth::user()->name . ' update team to ' . $team->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return new TeamResource(true, $team->name . ' has successfully been updated.', $team = [
            'team' => $team,
            'team_lead' => $team_lead
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // find data
        $team = Team::findOrFail($id);
        $team->delete();

        // deleted team lead and member
        // $team->lead()->detach();
        // $team->member()->detach();
        // soft delete to database
        $team->deleted_by = Auth::user()->id;
        $team->save();

        // activity log
        Activity::create([
            'log_name' => 'Delete Data',
            'description' => 'User ' . Auth::user()->name . ' delete team ' . $team->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
        ]);

        // return json response
        return new TeamResource(true, $team->name . ' has successfully been deleted.', null);
    }
}
