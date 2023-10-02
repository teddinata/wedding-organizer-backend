<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;
// use resource
use App\Http\Resources\ConfigLoanInstallment\ConfigLoanInstallmentCollection;
use App\Http\Resources\ConfigLoanInstallment\ConfigLoanInstallmentResource;
// model
use App\Models\MasterData\ConfigLoanInstallment;
// request
use App\Http\Requests\ConfigLoanInstallment\StoreInstallemntRequest;
use App\Http\Requests\ConfigLoanInstallment\UpdateInstallmentRequest;

class ConfigLoanInstallmentController extends Controller
{
    // use traits for success and error JSON response
    use ApiResponseTrait;

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

        //return resource collection
        return new ConfigLoanInstallmentCollection(true, 'Config Installment retrieved successfully', $query);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInstallemntRequest $request)
    {
        try {
            //store to database
            $query = ConfigLoanInstallment::create([
                'nominal' => $request->nominal,
                'created_by' => Auth::user()->id,
            ] + $request->validated());

            // activity log
            activity('created')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new ConfigLoanInstallmentResource($query), $query->nominal . ' has been created successfully.');
        } catch (\Throwable $th) {
            return $this->errorResponse('Data failed to save. Please try again!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // find the data by ID
        $query = ConfigLoanInstallment::findOrFail($id);

        //return JSON response
        return $this->successResponse(new ConfigLoanInstallmentResource($query), 'Data found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstallmentRequest $request, $id)
    {
        try {
            // find the data
            $query = ConfigLoanInstallment::findOrFail($id);

            // update to database
            $query->update(($request->validated() + [
                'nominal' => $request->nominal,
                'updated_by' => Auth::user()->id,
            ]));

            // activity log
            activity('updated')
                ->performedOn($query)
                ->causedBy(Auth::user());
            // return JSON response
            return $this->successResponse(new ConfigLoanInstallmentResource($query), 'Changes has been successfully saved.');
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'An error occurred. Data failed to update!'], 409);
        }
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
        activity('deleted')
            ->performedOn($query)
            ->causedBy(Auth::user());

        // return JSON response
        return $this->successResponse(new ConfigLoanInstallmentResource($query), $query->nominal . ' has been deleted successfully.');
    }
}
