<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;
// resource
use App\Http\Resources\ProductVariant\ProductVariantCollection;
use App\Http\Resources\ProductVariant\ProductVariantResource;
// model
use App\Models\MasterData\ProductVariant;
// request
use App\Http\Requests\ProductVariant\StoreProductVariantRequest;
use App\Http\Requests\ProductVariant\UpdateProductVariantRequest;

class ProductVariantController extends Controller
{
    // use traits for success and error JSON response
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all product variants with filter and pagination
        $query = ProductVariant::with(['product_attribute'])->orderBy('name', 'asc');

        // filter by name
        if (request()->has('search')) {
            $query->where('name', 'like', '%' . request('search') . '%');
        }

        // filter by product attribute
        if (request()->has('product_attribute_id')) {
            $query->where('product_attribute_id', request('product_attribute_id'));
        }

        // sort by name asc or desc
        if (request()->has('sort')) {
            $query->orderBy('name', request('sort'));
        }

        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // Get data
        $product_variants = $query->paginate($perPage, ['*'], 'page', $page);

        // return json response
        return new ProductVariantCollection(true, 'Product variant retrieved successfully', $product_variants);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductVariantRequest $request)
    {
        try {
            $query = ProductVariant::create([
                'product_attribute_id' => $request->product_attribute_id,
                'name' => $request->name,
            ] + $request->validated());

            // activity log
            activity('created')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new ProductVariantResource($query), $query->name . ' has been created successfully.');
        } catch (\Throwable $th) {
            return $this->errorResponse('Data failed to save. Please try again!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductVariant $productVariant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductVariantRequest $request, ProductVariant $productVariant)
    {
        try {
            // find data by id
            $query = ProductVariant::findOrFail($productVariant->id);

            // update data
            $query->update([
                'product_attribute_id' => $request->product_attribute_id,
                'name' => $request->name,
            ] + $request->validated());

            // activity log
            activity('updated')
                ->performedOn($query)
                ->causedBy(Auth::user());

            // return json response
            return $this->successResponse(new ProductVariantResource($query), 'Changes has been successfully saved.');
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'An error occurred. Data failed to update!'], 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariant $id)
    {
        // delete product variant by id
        $query = ProductVariant::findOrFail($id);
        $query->delete();
        $query->save();

        // activity log
        activity('deleted')
            ->performedOn($query)
            ->causedBy(Auth::user());

        // return json response
        return $this->successResponse(new ProductVariantResource($query), $query->name . ' has been deleted successfully.');
    }
}
