<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\ProductVariant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all product variants with filter and pagination
        $query = ProductVariant::query();

        // filter by name
        if (request()->has('name')) {
            $query->where('name', 'like', '%' . request('name') . '%');
        }

        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // Get data
        $product_variants = $query->paginate($perPage, ['*'], 'page', $page);

         // Log Activity
         Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' show data Product Variant',
            'description' => 'User ' . Auth::user()->name . ' show data Product Variant',
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
            'message' => 'Product Variants retrieved successfully.',
            'data' => $product_variants
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
            'product_attribute_id' => 'required|exists:product_attributes,id',
        ]);

        try {
            // create product variant
            $product_variant = new ProductVariant;
            $product_variant->name = $request->input('name');
            $product_variant->product_attribute_id = $request->input('product_attribute_id');
            $product_variant->created_by = Auth::user()->id;
            $product_variant->save();

            // Log Activity
            Activity::create([
                'log_name' => 'User ' . Auth::user()->name . ' store data Product Variant',
                'description' => 'User ' . Auth::user()->name . ' store data Product Variant',
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
                'message' => 'Product Variant created successfully.',
                'data' => $product_variant
            ], 201);
        } catch (\Exception $e) {
            // return json response
            return response()->json([
                'success' => false,
                'message' => 'Product Variant failed to save.',
                'data' => $e->getMessage()
            ], 500);
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
     * Show the form for editing the specified resource.
     */
    public function edit(ProductVariant $productVariant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductVariant $productVariant)
    {
        // validate incoming request

        $request->validate([
            'name' => 'required|string' . $productVariant->id,
            'product_attribute_id' => 'required|exists:product_attributes,id',
        ]);

        try {
            // update product variant
            $productVariant->update([
                'name' => $request->name,
                'product_attribute_id' => $request->product_attribute_id,
                'updated_by' => Auth::user()->id
            ]);

            // Log Activity
            Activity::create([
                'log_name' => 'User ' . Auth::user()->name . ' update data Product Variant',
                'description' => 'User ' . Auth::user()->name . ' update data Product Variant',
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
                'message' => 'Product Variant updated successfully.',
                'data' => $productVariant
            ], 200);
        } catch (\Exception $e) {
            // return json response
            return response()->json([
                'success' => false,
                'message' => 'Product Variant failed to update.',
                'data' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariant $productVariant)
    {
        // delete product variant by id
        $product_variant = ProductVariant::findOrFail($productVariant->id);
        $product_variant->delete();

        // Log Activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete data Product Variant',
            'description' => 'User ' . Auth::user()->name . ' delete data Product Variant',
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
            'message' => 'Product Variant deleted successfully.',
            'data' => $product_variant
        ], 200);

    }
}
