<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
    public function index(Request $request)
    {
        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        //set variable for search
        $search = $request->query('search');

        //set condition if search not empty then search by account_holder or account_number else then show all data
        if (!empty($search)) {
            $query = ConfigLoanInstallment::where('nominal', 'like', '%' . $search . '%')
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
            // get config installment data and sort by nominal ascending
            $query = ConfigLoanInstallment::orderBy('nominal', 'asc')->paginate($perPage, ['*'], 'page', $page);
        }

        //return collection of config installment as a resource
        return new ConfigLoanInstallmentResource(true, 'Config Installment retrieved successfully', $query);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInstallemntRequest $request)
    {
        //store to database
        $query = ConfigLoanInstallment::create([
            'nominal' => $request->nominal,
            'created_by' => Auth::user()->id,
        ] + $request->validated());

        // activity log
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' add installment configuration',
            'description' => 'User ' . Auth::user()->name . ' create installment configuration ' . $query->nominal,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now()
        ]);

        // return json response
        return new ConfigLoanInstallmentResource(true, $query->nominal . ' has successfully been created.', $query);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // find the data by ID
        $query = ConfigLoanInstallment::findOrFail($id);

        //return single post as a resource
        return new ConfigLoanInstallmentResource(true, 'Config installment found!', $query);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstallmentRequest $request, $id)
    {
        // find the data
        $query = ConfigLoanInstallment::findOrFail($id);

        // update to database
        $query->update(($request->validated() + [
            'nominal' => $request->nominal,
            'updated_by' => Auth::user()->id,
        ]));

        // activity log
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update installment configuration',
            'description' => 'User ' . Auth::user()->name . ' update config installment to ' . $query->nominal,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return new ConfigLoanInstallmentResource(true, $query->nominal . ' has successfully been updated.', $query);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find data
        $query = ConfigLoanInstallment::findOrFail($id);
        $query->delete();
        // soft delete to database
        $query->deleted_by = Auth::user()->id;
        $query->save();

        // activity log
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete installment configuration',
            'description' => 'User ' . Auth::user()->name . ' delete config installment ' . $query->nominal,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
        ]);

        // return json response
        return new ConfigLoanInstallmentResource(true, $query->nominal . ' has successfully been deleted.', null);
    }
}
