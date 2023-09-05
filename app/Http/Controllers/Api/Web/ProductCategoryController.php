<?php

namespace App\Http\Controllers\API\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
// use resource
use App\Http\Resources\ProductCategoryResource;
// model
use App\Models\MasterData\ProductCategory;
// request
use App\Http\Requests\ProductCategory\StoreProductCategoryRequest;
use App\Http\Requests\ProductCategory\UpdateProductCategoryRequest;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get product category data and sort by name ascending
        $category = ProductCategory::orderBy('name', 'asc')->paginate(10);
        //return collection of product category as a resource
        return new ProductCategoryResource(true, 'Product Category retrieved successfully', $category);

        // Log Activity
        Activity::create([
            'log_name' => 'Show Data',
            'description' => 'User ' . Auth::user()->name . ' Show sales list',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductCategoryRequest $request)
    {
        //store to database
        $category = ProductCategory::create([
            'name' => $request->name,
            'created_by' => Auth::user()->id,
        ] + $request->validated());

        // activity log
        Activity::create([
            'log_name' => 'Product Category Creation',
            'description' => 'User ' . Auth::user()->name . ' create product category ' . $category->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now()
        ]);

        // return json response
        return new ProductCategoryResource(true, $category->name . ' has successfully been created.', $category);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = ProductCategory::findOrFail($id);
        //return single post as a resource
        return new ProductCategoryResource(true, 'Data Category Found!', $category);

        // activity log
        Activity::create([
            'log_name' => 'View Data',
            'description' => 'User ' . Auth::user()->name . ' view sales ' . $category->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductCategoryRequest $request, $id)
    {
        // find the data
        $category = ProductCategory::findOrFail($id);

        // update to database
        $category->update(($request->validated() + [
            'name' => $request->name,
            'updated_by' => Auth::user()->id,
        ]));

        // activity log
        Activity::create([
            'log_name' => 'Update Data',
            'description' => 'User ' . Auth::user()->name . ' update product category to ' . $category->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return new ProductCategoryResource(true, $category->name . ' has successfully been updated.', $category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find data
        $category = ProductCategory::findOrFail($id);
        $category->delete();
        // soft delete to database
        $category->deleted_by = Auth::user()->id;
        $category->save();

        // activity log
        Activity::create([
            'log_name' => 'Delete Data',
            'description' => 'User ' . Auth::user()->name . ' delete product category ' . $category->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
        ]);

        // return json response
        return new ProductCategoryResource(true, $category->name . ' has successfully been deleted.', null);
    }
}
