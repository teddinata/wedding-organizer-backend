<?php

namespace App\Http\Controllers\API\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
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
    public function index()
    {
        // get bank account data and sort by account holder ascending
        $sales = BankAccount::orderBy('account_holder', 'asc')->paginate(10);
        //return collection of bank account as a resource
        return new BankAccountResource(true, 'Bank account retrieved successfully', $sales);

        // Log Activity
        Activity::create([
            'log_name' => 'Show Data',
            'description' => 'User ' . Auth::user()->name . ' Show bank account list',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBankAccountRequest $request)
    {
        //store to database
        $account = BankAccount::create([
            'bank' => $request->bank,
            'account_holder' => $request->account_holder,
            'account_number' => $request->account_number,
            'created_by' => Auth::user()->id,
        ] + $request->validated());

        // activity log
        Activity::create([
            'log_name' => 'Bank Account Creation',
            'description' => 'User ' . Auth::user()->name . ' create bank account ' . $account->account_holder,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now()
        ]);

        // return json response
        return new BankAccountResource(true, $account->account_holder . ' has successfully been created.', $account);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $account = BankAccount::findOrFail($id);
        //return single post as a resource
        return new BankAccountResource(true, 'Data Bank Account Found!', $account);

        // activity log
        Activity::create([
            'log_name' => 'View Data',
            'description' => 'User ' . Auth::user()->name . ' view bank account ' . $account->account_holder,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBankAccountRequest $request, $id)
    {
        // find the data
        $account = BankAccount::findOrFail($id);

        // update to database
        $account->update(($request->validated() + [
            'bank' => $request->bank,
            'account_holder' => $request->account_holder,
            'account_number' => $request->account_number,
            'updated_by' => Auth::user()->id,
        ]));

        // activity log
        Activity::create([
            'log_name' => 'Update Data',
            'description' => 'User ' . Auth::user()->name . ' update bank account ' . $account->account_holder,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return new BankAccountResource(true, $account->account_holder . ' has successfully been updated.', $account);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find data
        $account = BankAccount::findOrFail($id);
        $account->delete();
        // soft delete to database
        $account->deleted_by = Auth::user()->id;
        $account->save();

        // activity log
        Activity::create([
            'log_name' => 'Delete Data',
            'description' => 'User ' . Auth::user()->name . ' delete bank account ' . $account->account_holder,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
        ]);

        // return json response
        return new BankAccountResource(true, $account->account_holder . ' has successfully been deleted.', null);
    }
}
