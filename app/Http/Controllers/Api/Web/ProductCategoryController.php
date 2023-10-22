<?php

namespace App\Http\Controllers\API\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;
// use resource
use App\Http\Resources\ProductCategory\ProductCategoryCollection;
use App\Http\Resources\ProductCategory\ProductCategoryResource;
// model
use App\Models\MasterData\ProductCategory;
// request
use App\Http\Requests\ProductCategory\StoreProductCategoryRequest;
use App\Http\Requests\ProductCategory\UpdateProductCategoryRequest;

class ProductCategoryController extends Controller
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
            $query = ProductCategory::where('name', 'like', '%' . $search . '%')->withCount(['product_attributes'])->orderBy('name', 'asc')->get();
        } else {
            // get product category data and sort by name ascending
            $query = ProductCategory::withCount(['product_attributes'])->orderBy('name', 'asc')->get();
        }

        // request by id then show detail data, not array
        if ($request->has('id')) {
            $id = $request->input('id');

            // find the data by id
            $query = ProductCategory::findOrFail($id);

            //return JSON response
            return $this->successResponse(new ProductCategoryResource($query), 'Data found.');
        }

        //return resource collection
        $showData = new ProductCategoryCollection(true, 'Product category retrieved successfully', $query);
        return  $showData->paginate($perPage, $page);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductCategoryRequest $request)
    {
        try {
            //store to database
            $query = ProductCategory::create([
                'name' => $request->name,
            ] + $request->validated());

            // activity log
            activity('created')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return json response
            return $this->successResponse(new ProductCategoryResource($query), $query->name . ' has been created successfully.');
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
    public function update(UpdateProductCategoryRequest $request, $id)
    {
        try {
            // find the data
            $query = ProductCategory::findOrFail($id);

            // update to database
            $query->update(($request->validated() + [
                'name' => $request->name,
            ]));

            // activity log
            activity('updated')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return json response
            return $this->successResponse(new ProductCategoryResource($query), 'Changes has been successfully saved.');
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'An error occurred. Data failed to update!'], 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find data by ID
        $query = ProductCategory::findOrFail($id);
        $query->delete();
        $query->save();

        // activity log
        activity('deleted')
            ->performedOn($query)
            ->causedBy(Auth::user());

        // return JSON response
        return $this->successResponse(new ProductCategoryResource($query), $query->name . ' has been deleted successfully.');
    }
}
