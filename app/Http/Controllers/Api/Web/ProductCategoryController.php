<?php

namespace App\Http\Controllers\API\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
    public function index(Request $request)
    {
        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        //set variable for search
        $search = $request->query('search');

        //set condition if search not empty then find by name else then show all data
        if (!empty($search)) {
            $query = ProductCategory::where('name', 'like', '%' . $search . '%')->paginate($perPage, ['*'], 'page', $page);

            //check result
            $recordsTotal = $query->count();
            if (empty($recordsTotal)) {
                return response(['Message' => 'Data not found!'], 404);
            }
        } else {
            // get product category data and sort by name ascending
            $query = ProductCategory::withCount(['product_attributes'])->orderBy('name', 'asc')->paginate($perPage, ['*'], 'page', $page);
        }

        //return collection of product category as a resource
        return new ProductCategoryResource(true, 'Product Category retrieved successfully', $query);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductCategoryRequest $request)
    {
        //store to database
        $query = ProductCategory::create([
            'name' => $request->name,
            'created_by' => Auth::user()->id,
        ] + $request->validated());

        // activity log
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' add new product category',
            'description' => 'User ' . Auth::user()->name . ' create product category ' . $query->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now()
        ]);

        // return json response
        return new ProductCategoryResource(true, $query->name . ' has successfully been created.', $query);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // find data by ID
        $query = ProductCategory::findOrFail($id);

        //return single post as a resource
        return new ProductCategoryResource(true, 'Data Category Found!', $query);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductCategoryRequest $request, $id)
    {
        // find the data
        $query = ProductCategory::findOrFail($id);

        // update to database
        $query->update(($request->validated() + [
            'name' => $request->name,
            'updated_by' => Auth::user()->id,
        ]));

        // activity log
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update product category',
            'description' => 'User ' . Auth::user()->name . ' update product category to ' . $query->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return json response
        return new ProductCategoryResource(true, $query->name . ' has successfully been updated.', $query);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find data by ID
        $query = ProductCategory::findOrFail($id);
        $query->delete();
        // soft delete to database
        $query->deleted_by = Auth::user()->id;
        $query->save();

        // activity log
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete product category',
            'description' => 'User ' . Auth::user()->name . ' delete product category ' . $query->name,
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
        ]);

        // return json response
        return new ProductCategoryResource(true, $query->name . ' has successfully been deleted.', null);
    }
}
