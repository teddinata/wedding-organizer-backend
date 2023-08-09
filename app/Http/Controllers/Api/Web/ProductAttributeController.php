<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class ProductAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all product attributes with filter and pagination
        $query = ProductAttribute::query();

        // filter by name
        if (request()->has('name')) {
            $query->where('name', 'like', '%' . request('name') . '%');
        }

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
        return response()->json([
            'success' => true,
            'message' => 'Product Attributes retrieved successfully.',
            'data' => $product_attributes
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
            'product_category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string',
        ]);

        $product_attribute = ProductAttribute::create([
            'name' => $request->input('name'),
            'product_category_id' => $request->input('product_category_id'),
            'created_by' => Auth::user()->id,
        ]);


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
        return response()->json([
            'success' => true,
            'message' => 'Product Attribute created successfully.',
            'data' => $product_attribute
        ], 201);

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
    public function update(Request $request, ProductAttribute $productAttribute)
    {
        // validate incoming request
        $request->validate([
            'product_category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string' . $productAttribute->id,
        ]);

        try {
            $productAttribute->name = $request->input('name');
            $productAttribute->product_category_id = $request->input('product_category_id');
            $productAttribute->updated_by = Auth::user()->id;
            $productAttribute->save();
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

            // return data after store
            return response()->json([
                'success' => true,
                'message' => 'Product Attribute updated successfully.',
                'data' => $productAttribute
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product Attribute failed to update.',
            ], 409);
        }


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
        return response()->json([
            'success' => true,
            'message' => 'Product Attribute deleted successfully.',
        ], 200);
    }
}
