<?php

namespace App\Http\Controllers\API\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
// use resource
use App\Http\Resources\ConfigLoanInstallmentResource;
// model
use App\Models\MasterData\ConfigLoanInstallment;
// request
use App\Http\Requests\ConfigLoanInstallment\StoreInstallemntRequest;
use App\Http\Requests\ConfigLoanInstallment\UpdateInstallmentRequest;

class ConfigLoanInstallmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get sales data and sort by name ascending
        $installment = ConfigLoanInstallment::orderBy('nominal', 'asc')->paginate(10);
        //return collection of sales as a resource
        return new ConfigLoanInstallmentResource(true, 'Config Installment retrieved successfully', $installment);

        // Log Activity
        Activity::create([
            'log_name' => 'Show Data',
            'description' => 'User ' . Auth::user()->name . ' Show config installment list',
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
    public function store(StoreInstallemntRequest $request)
    {
        //store to database
        $installment = ConfigLoanInstallment::create([
            'nominal' => $request->nominal,
            'created_by' => Auth::user()->id,
        ] + $request->validated());

        // activity log
        Activity::create([
            'log_name' => 'Config Loan Installment Creation',
            'description' => 'User ' . Auth::user()->name . ' create config installment ' . $installment->nominal,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now()
        ]);

        // return json response
        return new ConfigLoanInstallmentResource(true, $installment->nominal . ' has successfully been created.', $installment);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstallmentRequest $request, $id)
    {
        // find the data
        $installment = ConfigLoanInstallment::findOrFail($id);

        // update to database
        $installment->update(($request->validated() + [
            'nominal' => $request->nominal,
            'updated_by' => Auth::user()->id,
        ]));

        // activity log
        Activity::create([
            'log_name' => 'Update Data',
            'description' => 'User ' . Auth::user()->name . ' update config installment to ' . $installment->nominal,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return new ConfigLoanInstallmentResource(true, $installment->nominal . ' has successfully been updated.', $installment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find data
        $installment = ConfigLoanInstallment::findOrFail($id);
        $installment->delete();
        // soft delete to database
        $installment->deleted_by = Auth::user()->id;
        $installment->save();

        // activity log
        Activity::create([
            'log_name' => 'Delete Data',
            'description' => 'User ' . Auth::user()->name . ' delete config installment ' . $installment->nominal,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
        ]);

        // return json response
        return new ConfigLoanInstallmentResource(true, $installment->nominal . ' has successfully been deleted.', null);
    }
}
