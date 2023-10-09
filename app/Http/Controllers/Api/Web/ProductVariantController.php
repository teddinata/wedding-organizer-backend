<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\MasterData\ProductVariant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Resources\ProductVariantResource;
use App\Http\Requests\ProductVariant\StoreProductVariantRequest;
use App\Http\Requests\ProductVariant\UpdateProductVariantRequest;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all product variants with filter and pagination
        $query = ProductVariant::orderBy('name', 'asc');

        // filter by product attribute
        if (request()->has('product_attribute_id')) {
            $query->where('product_attribute_id', request('product_attribute_id'));
        }

        // filter by name
        if (request()->has('search')) {
            $query->where('name', 'like', '%' . request('name') . '%');
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
        return new ProductVariantResource(true, 'Product Variant retrieved successfully', $product_variants);
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
    public function store(StoreProductVariantRequest $request)
    {
        $product_variant = ProductVariant::create([
            'name' => $request->name,
            'product_attribute_id' => $request->product_attribute_id,
            'created_by' => Auth::user()->id
        ] + $request->validated());

        // Log Activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' create data Product Variant ' . $product_variant->name,
            'description' => 'User ' . Auth::user()->name . ' create data Product Variant ' . $product_variant->name,
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
        return new ProductVariantResource(true, 'Product Variant created successfully', $product_variant);
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
    public function update(UpdateProductVariantRequest $request, ProductVariant $productVariant)
    {
        $product_variant = ProductVariant::findOrFail($productVariant->id);
        $product_variant->update([
            'name' => $request->name,
            'product_attribute_id' => $request->product_attribute_id,
            'updated_by' => Auth::user()->id
        ] + $request->validated());

        // Log Activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update data Product Variant ' . $product_variant->name,
            'description' => 'User ' . Auth::user()->name . ' update data Product Variant ' . $product_variant->name,
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
        return new ProductVariantResource(true, 'Product Variant updated successfully', $product_variant);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariant $productVariant)
    {
        // delete product variant by id
        $product_variant = ProductVariant::findOrFail($productVariant->id);
        $product_variant->delete();

        // deleted by
        $product_variant->deleted_by = Auth::user()->id;
        $product_variant->save();

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
        return new ProductVariantResource(true, 'Product Variant deleted successfully', $product_variant);
    }
}
