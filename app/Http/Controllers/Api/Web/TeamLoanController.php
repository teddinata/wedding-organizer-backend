<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\Operational\TeamLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use App\Http\Resources\TeamResource;
use App\Http\Requests\TeamLoan\StoreTeamLoanRequest;
use App\Http\Requests\TeamLoan\UpdateTeamLoanRequest;


class TeamLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all team loan with request filter conditional
        $query = TeamLoan::orderBy('created_at', 'desc');

        // filter by team id
        if (request()->has('search')) {
            $query->where('team_id', request('search'));
        }

        // get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // get data
        $teamLoans = $query->paginate($perPage, ['*'], 'page', $page);

        // return json response
        return new TeamResource(true, 'Team Resources retrieved successfully', $teamLoans);
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
    public function store(StoreTeamLoanRequest $request)
    {
        // create new team loan
        $teamLoan = TeamLoan::create([
            'loan_number' => $request->loan_number,
            'loan_date' => $request->loan_date,
            'team_id' => $request->team_id,
            'description' => $request->description,
            'loan_amount' => $request->loan_amount,
            'loan_status' => $request->loan_status,
            'created_by' => Auth::user()->id,
        ] + $request->validated());

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' store data Team Loan',
            'description' => 'User ' . Auth::user()->name . ' store data Team Loan',
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
        return new TeamResource(true, 'Team Loan created successfully', $teamLoan);
    }

    /**
     * Display the specified resource.
     */
    public function show(TeamLoan $teamLoan)
    {
        // show detail loan
        $loan = TeamLoan::with('team')->find($teamLoan->id);

        // logs
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' show detail data Team Loan',
            'description' => 'User ' . Auth::user()->name . ' show detail data Team Loan',
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
        return new TeamResource(true, 'Team Loan retrieved successfully', $loan);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeamLoan $teamLoan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeamLoanRequest $request, TeamLoan $teamLoan)
    {
        // update team loan
        $teamLoan->update([
            'loan_number' => $request->loan_number,
            'loan_date' => $request->loan_date,
            'team_id' => $request->team_id,
            'description' => $request->description,
            'loan_amount' => $request->loan_amount,
            'loan_status' => $request->loan_status,
            'updated_by' => Auth::user()->id,
        ] + $request->validated());

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update data Team Loan',
            'description' => 'User ' . Auth::user()->name . ' update data Team Loan',
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
        return new TeamResource(true, 'Team Loan updated successfully', $teamLoan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find team loan by id
        $teamLoan = TeamLoan::findOrFail($id);

        // delete team loan
        $teamLoan->delete();

        // deleted by
        $teamLoan->deleted_by = Auth::user()->id;
        $teamLoan->save();

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete data Team Loan',
            'description' => 'User ' . Auth::user()->name . ' delete data Team Loan',
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
        return new TeamResource(true, 'Team Loan deleted successfully', null);
    }
}
