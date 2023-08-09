<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;


class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all product categories with filter and pagination
        $query = ProductCategory::query();

        // filter by name
        if (request()->has('name')) {
            $query->where('name', 'like', '%' . request('name') . '%');
        }

        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // Get data
        $product_categories = $query->paginate($perPage, ['*'], 'page', $page);

        // Log Activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' show data Product Category',
            'description' => 'User ' . Auth::user()->name . ' show data Product Category',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return response()->json([
            'success' => true,
            'message' => 'Product Categories retrieved successfully.',
            'data' => $product_categories
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate incoming request
        $request->validate([
            'name' => 'required|string',
        ]);

        try {
            $product_category = new ProductCategory;
            $product_category->name = $request->input('name');
            $product_category->created_by = Auth::user()->id;
            $product_category->save();

            // activity log
            Activity::create([
                'log_name' => 'User ' . Auth::user()->name . ' create data Product Category ' . $product_category->name,
                'description' => 'User ' . Auth::user()->name . ' create data Product Category ' . $product_category->name,
                'subject_id' => Auth::user()->id,
                'subject_type' => 'App\Models\User',
                'causer_id' => Auth::user()->id,
                'causer_type' => 'App\Models\User',
                'properties' => request()->ip(),
                // 'host' => request()->ip(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // return json response
            return response()->json([
                'success' => true,
                'message' => 'Product Category saved successfully.',
                'data' => $product_category
            ], 201);
        } catch (\Exception $e) {

            // return json response
            return response()->json([
                'success' => false,
                'message' => 'Product Category failed to save.',
                'data' => $e->getMessage()
            ], 409);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        // validate incoming request
        $request->validate([
            'name' => 'required|string' . $productCategory->id,
        ]);

        $product_category = ProductCategory::findOrFail($productCategory->id);

        try {
            $product_category->name = $request->input('name');
            $product_category->updated_by = Auth::user()->id;
            $product_category->save();

            // activity log
            Activity::create([
                'log_name' => 'User ' . Auth::user()->name . ' update data Product Category ' . $product_category->name,
                'description' => 'User ' . Auth::user()->name . ' update data Product Category ' . $product_category->name,
                'subject_id' => Auth::user()->id,
                'subject_type' => 'App\Models\User',
                'causer_id' => Auth::user()->id,
                'causer_type' => 'App\Models\User',
                'properties' => request()->ip(),
                // 'host' => request()->ip(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // return json response
            return response()->json([
                'success' => true,
                'message' => 'Product Category updated successfully.',
                'data' => $product_category
            ], 201);
        } catch (\Exception $e) {

            // return json response
            return response()->json([
                'success' => false,
                'message' => 'Product Category failed to update.',
                'data' => $e->getMessage()
            ], 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {

        // get product category
        $product_category = ProductCategory::findOrFail($productCategory->id);

        try {
            $product_category->delete();
            // delete data product attribute by product category id
            ProductAttribute::where('product_category_id', $productCategory->id)->delete();

            // activity log
            Activity::create([
                'log_name' => 'User ' . Auth::user()->name . ' delete data Product Category ' . $product_category->name,
                'description' => 'User ' . Auth::user()->name . ' delete data Product Category ' . $product_category->name,
                'subject_id' => Auth::user()->id,
                'subject_type' => 'App\Models\User',
                'causer_id' => Auth::user()->id,
                'causer_type' => 'App\Models\User',
                'properties' => request()->ip(),
                // 'host' => request()->ip(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // return json response
            return response()->json([
                'success' => true,
                'message' => 'Product Category deleted successfully.',
                'data' => $product_category
            ], 201);
        } catch (\Exception $e) {

            // return json response
            return response()->json([
                'success' => false,
                'message' => 'Product Category failed to delete.',
                'data' => $e->getMessage()
            ], 409);
        }
    }
}
