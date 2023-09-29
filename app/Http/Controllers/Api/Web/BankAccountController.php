<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
// use resource
use App\Http\Resources\BankAccountResource;
// model
use App\Models\MasterData\BankAccount;
// request
use App\Http\Requests\BankAccount\StoreBankAccountRequest;
use App\Http\Requests\BankAccount\UpdateBankAccountRequest;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        //set variable for search
        $search = $request->query('search');

        //set condition if search not empty then search by account_holder or account_number else then show all data
        if (!empty($search)) {
            $query = BankAccount::where('account_holder', 'like', '%' . $search . '%')
                ->orWhere(
                    'account_number',
                    'like',
                    '%' . $search . '%'
                )
                ->paginate(
                    $perPage,
                    ['*'],
                    'page',
                    $page
                );

            //check result
            $recordsTotal = $query->count();
            if (empty($recordsTotal)) {
                return response(['Message' => 'Data not found!'], 404);
            }
        } else {
            // get bank account data and sort by account_holder ascending
            $query = BankAccount::orderBy('account_holder', 'asc')->paginate($perPage, ['*'], 'page', $page);
        }

        //return collection of bank account as a resource
        return new BankAccountResource(true, 'Bank account retrieved successfully', $query);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBankAccountRequest $request)
    {
        //store to database
        $query = BankAccount::create([
            'bank' => $request->bank,
            'account_holder' => $request->account_holder,
            'account_number' => $request->account_number,
            'created_by' => Auth::user()->id,
        ] + $request->validated());

        // activity log
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' add bank account',
            'description' => 'User ' . Auth::user()->name . ' create bank account ' . $query->account_holder,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now()
        ]);

        // return json response
        return new BankAccountResource(true, $query->account_holder . ' has successfully been created.', $query);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // find the data by id
        $query = BankAccount::findOrFail($id);

        //return single post as a resource
        return new BankAccountResource(true, 'Bank account found!', $query);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBankAccountRequest $request, $id)
    {
        // check the data by id
        $query = BankAccount::findOrFail($id);

        // update to database
        $query->update(($request->validated() + [
            'bank' => $request->bank,
            'account_holder' => $request->account_holder,
            'account_number' => $request->account_number,
            'updated_by' => Auth::user()->id,
        ]));

        // activity log
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update bank account',
            'description' => 'User ' . Auth::user()->name . ' update bank account ' . $query->account_holder,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return new BankAccountResource(true, $query->account_holder . ' has successfully been updated.', $query);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find data
        $query = BankAccount::findOrFail($id);
        $query->delete();
        // soft delete to database
        $query->deleted_by = Auth::user()->id;
        $query->save();

        // activity log
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete bank account',
            'description' => 'User ' . Auth::user()->name . ' delete bank account ' . $query->account_holder,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
        ]);

        // return json response
        return new BankAccountResource(true, $query->account_holder . ' has successfully been deleted.', null);
    }
}
