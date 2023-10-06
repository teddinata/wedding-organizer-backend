<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;
// resource
use App\Http\Resources\ProductAttribute\ProductAttributeCollection;
use App\Http\Resources\ProductAttribute\ProductAttributeResource;
// model
use App\Models\MasterData\ProductAttribute;
// request
use App\Http\Requests\ProductAttribute\StoreProductAttributeRequest;
use App\Http\Requests\ProductAttribute\UpdateProductAttributeRequest;

class ProductAttributeController extends Controller
{
    // use traits for success and error JSON response
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all product attributes with filter and pagination
        $query = ProductAttribute::with(['product_category'])->orderBy('name', 'asc');

        // filter by name
        if (request()->has('search')) {
            $query->where('name', 'like', '%' . request('search') . '%');
        }

        // filter by product category
        if (request()->has('product_category_id')) {
            $query->where('product_category_id', request('product_category_id'));
        }

        // request sort by name asc or desc
        if (request()->has('sort')) {
            $query->orderBy('name', request('sort'));
        }

        // count product variant in each product attribute
        $query->withCount(['product_variants']);

        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // Get data
        $product_attributes = $query->paginate($perPage, ['*'], 'page', $page);

        // return json response
        return new ProductAttributeCollection(true, 'Product attributes retrieved successfully', $product_attributes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductAttributeRequest $request)
    {
        try {
            $query = ProductAttribute::create([
                'product_category_id' => $request->input('product_category_id'),
                'name' => $request->input('name'),
                'created_by' => Auth::user()->id,
            ] + $request->validated());

            // activity log
            activity('created')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new ProductAttributeResource($query), $query->name . ' has been created successfully.');
        } catch (\Throwable $th) {
            return $this->errorResponse('Data failed to save. Please try again!');
        }
        // if not duplicate data then store data to database and return success response with data created, if duplicate data then return error response
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductAttribute $productAttribute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductAttributeRequest $request, $id)
    {
        try {
            // find data by id
            $query = ProductAttribute::findOrFail($id);

            // update data
            $query->update([
                'product_category_id' => $request->input('product_category_id'),
                'name' => $request->input('name'),
                'updated_by' => Auth::user()->id,
            ] + $request->validated());

            // activity log
            activity('updated')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return json response
            return $this->successResponse(new ProductAttributeResource($query), 'Changes has been successfully saved.');
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'An error occurred. Data failed to update!'], 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductAttribute $id)
    {
        // find data by id
        $query = ProductAttribute::findOrFail($id);
        $query->delete();
        // deleted by
        $query->deleted_by = Auth::user()->id;
        $query->save();

        // activity log
        activity('deleted')
            ->performedOn($query)
            ->causedBy(Auth::user());

        // return json response
        return $this->successResponse(new ProductAttributeResource($query), $query->name . ' has been deleted successfully.');
    }
}
