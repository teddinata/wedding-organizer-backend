<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;
// use resource
use App\Http\Resources\VendorLimit\VendorLimitCollection;
use App\Http\Resources\VendorLimit\VendorLimitResource;
// model
use App\Models\MasterData\VendorLimit;
// request
use App\Http\Requests\VendorLimit\StoreVendorLimitRequest;
use App\Http\Requests\VendorLimit\UpdateVendorLimitRequest;


class VendorLimitController extends Controller
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

        //set condition if search not empty then find by name else then show all data
        if (!empty($search)) {
            $query = VendorLimit::where('name', 'like', '%' . $search . '%')
                ->orWhere(
                    'amount_limit',
                    'like',
                    '%' . $search . '%'
                )
                ->get();
        } else {
            // get grade data and sort by id ascending
            $query = VendorLimit::orderBy('amount_limit', 'desc')->get();
        }

        // request by id then show detail data, not array
        if ($request->has('id')) {
            $id = $request->input('id');

            // find the data by id
            $query = VendorLimit::findOrFail($id);

            //return JSON response
            return $this->successResponse(new VendorLimitResource($query), 'Data found.');
        }

        //return resource collection
        $showData = new VendorLimitCollection(true, 'Vendor limit retrieved successfully', $query);
        return  $showData->paginate($perPage, $page);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVendorLimitRequest $request)
    {
        try {

            // check if amount limit is greater than data that already exists
            $check = VendorLimit::where('amount_limit', '>', $request->amount_limit)->first();
            // check if data not found
            if (!$check) {
                // create vendor limit
                $query = VendorLimit::create([
                    'name' => request('name'),
                    'amount_limit' => request('amount_limit'),
                ] + $request->validated());
            } else {
                // return error response
                return $this->errorResponse('Amount limit must be greater than ' . $check->name . '!');
            }

            // activity log
            activity('created')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new VendorLimitResource($query), $query->name . ' has been created successfully.');
        } catch (\Throwable $th) {
            return $this->errorResponse('Data failed to save. Please try again!');
        }
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
    public function update(UpdateVendorLimitRequest $request, string $id)
    {
        try {
            // get vendor limit by id
            $query = VendorLimit::findOrFail($id);

            // check if amount limit is greater than data that already exists
            $check = VendorLimit::where('amount_limit', '>', $request->amount_limit)->first();
            // check if data not found
            if (!$check) {
                // update vendor limit
                $query->update([
                    'name' => request('name'),
                    'amount_limit' => request('amount_limit'),
                ] + $request->validated());
            } else {
                // return error response
                return $this->errorResponse('Amount limit must be greater than ' . $check->name . '!');
            }

            // activity log
            activity('updated')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new VendorLimitResource($query), 'Changes has been successfully saved.');
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'An error occurred. Data failed to update!'], 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // find data
        $query = VendorLimit::findOrFail($id);
        $query->delete();
        $query->save();

        // activity log
        activity('deleted')
            ->performedOn($query)
            ->causedBy(Auth::user());

        // return json response
        return $this->successResponse(new VendorLimitResource($query), $query->name . ' has been deleted successfully.');
    }
}
