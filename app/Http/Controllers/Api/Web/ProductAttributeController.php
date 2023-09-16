<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\MasterData\ProductAttribute;
use App\Models\MasterData\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use App\Http\Resources\ProductAttributeResource;
use App\Http\Requests\ProductAttribute\StoreProductAttributeRequest;
use App\Http\Requests\ProductAttribute\UpdateProductAttributeRequest;

class ProductAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all product attributes with filter and pagination
        $query = ProductAttribute::orderBy('name', 'asc');

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

         // Log Activity
         Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' show data Product Attribute',
            'description' => 'User ' . Auth::user()->name . ' show data Product Attribute',
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
        return new ProductAttributeResource(true, 'Product Attributes retrieved successfully', $product_attributes);
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
    public function store(StoreProductAttributeRequest $request)
    {
        $product_attribute = ProductAttribute::create([
            'name' => $request->input('name'),
            'product_category_id' => $request->input('product_category_id'),
            'created_by' => Auth::user()->id,
        ] + $request->validated());


         // activity log
         Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' create data Product Attribute ' . $product_attribute->name,
            'description' => 'User ' . Auth::user()->name . ' create data Product Attribute ' . $product_attribute->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // if not duplicate data then store data to database and return success response with data created, if duplicate data then return error response


        // return json response
        return new ProductAttributeResource(true, 'Product Attribute created successfully', $product_attribute);

    }

    /**
     * Display the specified resource.
     */
    public function show(ProductAttribute $productAttribute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductAttribute $productAttribute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductAttributeRequest $request, ProductAttribute $productAttribute)
    {
        // find data by id
        $productAttribute = ProductAttribute::findOrFail($productAttribute->id);

        // update data
        $productAttribute->update([
            'name' => $request->input('name'),
            'product_category_id' => $request->input('product_category_id'),
            'updated_by' => Auth::user()->id,
        ] + $request->validated());

        // activity log
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update data Product Attribute ' . $productAttribute->name,
            'description' => 'User ' . Auth::user()->name . ' update data Product Attribute ' . $productAttribute->name,
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
        return new ProductAttributeResource(true, 'Product Attribute updated successfully', $productAttribute);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductAttribute $productAttribute)
    {

        // find data by id
        $productAttribute = ProductAttribute::findOrFail($productAttribute->id);

        // delete data
        $productAttribute->delete();

        // deleted by
        $productAttribute->deleted_by = Auth::user()->id;
        $productAttribute->save();

        // activity log
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete data Product Attribute ' . $productAttribute->name,
            'description' => 'User ' . Auth::user()->name . ' delete data Product Attribute ' . $productAttribute->name,
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
        return new ProductAttributeResource(true, 'Product Attribute deleted successfully', $productAttribute);
    }
}
