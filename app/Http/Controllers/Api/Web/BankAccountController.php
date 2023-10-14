<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;
// use resource
use App\Http\Resources\BankAccount\BankAccountCollection;
use App\Http\Resources\BankAccount\BankAccountResource;
// model
use App\Models\MasterData\BankAccount;
// request
use App\Http\Requests\BankAccount\StoreBankAccountRequest;
use App\Http\Requests\BankAccount\UpdateBankAccountRequest;

class BankAccountController extends Controller
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

        // request by id then show detail data, not array
        if ($request->has('id')) {
            $id = $request->input('id');

            // find the data by id
            $query = BankAccount::findOrFail($id);

            //return JSON response
            return $this->successResponse(new BankAccountResource($query), 'Data found.');
        }

        //return resource collection
        return new BankAccountCollection(true, 'Bank account retrieved successfully', $query);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBankAccountRequest $request)
    {
        try {
            //store to database
            $query = BankAccount::create([
                'bank' => $request->bank,
                'account_holder' => $request->account_holder,
                'account_number' => $request->account_number,
                'created_by' => Auth::user()->id,
            ] + $request->validated());

            // activity log
            activity('created')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new BankAccountResource($query), $query->account_holder . ' has been created successfully.');
        } catch (\Throwable $th) {
            return $this->errorResponse('Data failed to save. Please try again!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBankAccountRequest $request, $id)
    {
        try {
            // find the data
            $query = BankAccount::findOrFail($id);

            // update to database
            $query->update(($request->validated() + [
                'bank' => $request->bank,
                'account_holder' => $request->account_holder,
                'account_number' => $request->account_number,
                'updated_by' => Auth::user()->id,
            ]));

            // activity log
            activity('updated')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new BankAccountResource($query), 'Changes has been successfully saved.');
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
        $query = BankAccount::findOrFail($id);
        $query->delete();
        // soft delete to database
        $query->deleted_by = Auth::user()->id;
        $query->save();

        // activity log
        activity('deleted')
            ->performedOn($query)
            ->causedBy(Auth::user());

        // return JSON response
        return $this->successResponse(new BankAccountResource($query), $query->account_holder . ' has been deleted successfully.');
    }
}
