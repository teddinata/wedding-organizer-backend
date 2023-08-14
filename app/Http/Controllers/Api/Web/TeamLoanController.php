<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\TeamLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class TeamLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all team loan with request filter conditional
        $query = TeamLoan::query();

        // filter by team id
        if (request()->has('team_id')) {
            $query->where('team_id', request('team_id'));
        }

        // get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // get data
        $teamLoans = $query->paginate($perPage, ['*'], 'page', $page);

        // return json response
        return response()->json([
            'success' => true,
            'message' => 'Team Loans retrieved successfully.',
            'data' => $teamLoans
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
            'team_id' => 'required|exists:teams,id',
            'loan_number' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'status' => 'required|in:waiting approval, on going, paid, rejected',
        ]);

        // create new team loan
        $teamLoan = TeamLoan::create([
            'team_id' => $request->team_id,
            'loan_number' => $request->loan_number,
            'description' => $request->description,
            'amount' => $request->amount,
            'status' => $request->status,
            'created_by' => Auth::user()->id,
        ]);

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
        return response()->json([
            'success' => true,
            'message' => 'Team Loan created successfully.',
            'data' => $teamLoan
        ], 200);
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
        return response()->json([
            'success' => true,
            'message' => 'Team Loan retrieved successfully.',
            'data' => $loan
        ], 200);
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
    public function update(Request $request, TeamLoan $teamLoan)
    {
        // validate request
        $request->validate([
            'team_id' => 'required|exists:teams,id',
            'loan_number' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'status' => 'required|in:waiting approval, on going, paid, rejected',
        ]);

        // update team loan
        $teamLoan->update([
            'team_id' => $request->team_id,
            'loan_number' => $request->loan_number,
            'description' => $request->description,
            'amount' => $request->amount,
            'status' => $request->status,
            'updated_by' => Auth::user()->id,
        ]);

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
        return response()->json([
            'success' => true,
            'message' => 'Team Loan updated successfully.',
            'data' => $teamLoan
        ], 200);
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
        return response()->json([
            'success' => true,
            'message' => 'Team Loan deleted successfully.',
            'data' => $teamLoan
        ], 200);
    }
}
