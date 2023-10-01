<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Symfony\Component\HttpKernel\Exception\HttpException;
// use resource
use App\Http\Resources\SalesResource;
// model
use App\Models\MasterData\Sales;
// request
use App\Http\Requests\Sales\StoreSalesRequest;
use App\Http\Requests\Sales\UpdateSalesRequest;

class SalesController extends Controller
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

        //set condition if search not empty then find by name else then show all data
        if (!empty($search)) {
            $query = Sales::where('name', 'like', '%' . $search . '%')->paginate($perPage, ['*'], 'page', $page);

            //check result
            $recordsTotal = $query->count();
            if (empty($recordsTotal)) {
                return response(['Message' => 'Data not found!'], 404);
            }
        } else {
            // get sales data and sort by name ascending
            $query = Sales::orderBy('name', 'asc')->paginate($perPage, ['*'], 'page', $page);
        }

        //return resource collection 
        return (SalesResource::collection($query))->additional(['status' => true, 'message' => 'Sales retrieved successfully.']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSalesRequest $request)
    {
        try {
            //store to database
            $query = Sales::create([
                'name' => $request->name,
                'created_by' => Auth::user()->id,
            ] + $request->validated());

            // activity log
            activity('created')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return resource
            return (new SalesResource($query))->additional(['status' => true, 'message' => $query->name . ' has been created.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Data failed to save. Please try again!',], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // find the data by id
        $query = Sales::findOrFail($id);

        //return single post as a resource
        return (new SalesResource($query))->additional(['status' => true, 'message' => 'Data found!']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalesRequest $request, $id)
    {
        try {
            // find the data
            $query = Sales::findOrFail($id);

            // update to database
            $query->update(($request->validated() + [
                'name' => $request->name,
                'updated_by' => Auth::user()->id,
            ]));

            // activity log
            activity('updated')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return resource
            return (new SalesResource($query))->additional(['status' => true, 'message' => 'Changes has been successfully saved.']);
        } catch (\Exception $e) {
            //return $e->getMessage();
            return response()->json(['success' => false, 'message' => 'Something went wrong. Data failed to update!'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find data
        $query = Sales::findOrFail($id);
        $query->delete();
        // soft delete to database
        $query->deleted_by = Auth::user()->id;
        $query->save();

        // activity log
        activity('deleted')
            ->performedOn($query)
            ->causedBy(Auth::user());

        // return resource
        return (new SalesResource($query))->additional(['status' => true, 'message' => $query->name . ' has been deleted successfully.']);
    }
}
