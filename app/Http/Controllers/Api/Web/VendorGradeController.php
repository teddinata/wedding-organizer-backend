<?php

namespace App\Http\Controllers\API\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;
// use resource
use App\Http\Resources\VendorGrade\VendorGradeCollection;
use App\Http\Resources\VendorGrade\VendorGradeResource;
// model
use App\Models\MasterData\VendorGrade;
// request
use App\Http\Requests\VendorGrade\StoreVendorGradeRequest;
use App\Http\Requests\VendorGrade\UpdateVendorGradeRequest;

class VendorGradeController extends Controller
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
            $query = VendorGrade::where('name', 'like', '%' . $search . '%')->paginate($perPage, ['*'], 'page', $page);

            //check result
            $recordsTotal = $query->count();
            if (empty($recordsTotal)) {
                return response(['Message' => 'Data not found!'], 404);
            }
        } else {
            // get grade data and sort by id ascending
            $query = VendorGrade::orderBy('id', 'asc')->paginate($perPage, ['*'], 'page', $page);
        }

        //return collection of grade vendor as a resource
        return new VendorGradeCollection(true, 'Grade retrieved successfully', $query);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVendorGradeRequest $request)
    {
        try {
            //store to database
            $query = VendorGrade::create([
                'name' => $request->name,
                'description' => $request->description,
                'created_by' => Auth::user()->id,
            ] + $request->validated());

            // activity log
            activity('created')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new VendorGradeResource($query), $query->name . ' has been created successfully.');
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
    public function update(UpdateVendorGradeRequest $request, $id)
    {
        try {
            // find the data
            $query = VendorGrade::findOrFail($id);

            // update to database
            $query->update(($request->validated() + [
                'name' => $request->name,
                'description' => $request->description,
                'updated_by' => Auth::user()->id,
            ]));

            // activity log
            activity('updated')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new VendorGradeResource($query), 'Changes has been successfully saved.');
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
        $query = VendorGrade::findOrFail($id);
        $query->delete();
        // soft delete to database
        $query->deleted_by = Auth::user()->id;
        $query->save();

        // activity log
        activity('deleted')
            ->performedOn($query)
            ->causedBy(Auth::user());

        // return json response
        return $this->successResponse(new VendorGradeResource($query), $query->name . ' has been deleted successfully.');
    }
}
