<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\MasterData\ChecklistCategory;
use Illuminate\Http\Request;
use App\Http\Resources\ChecklistCategoryResource;

class ChecklistCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $checklist_category = ChecklistCategory::orderBy('name', 'asc');

        // filter by name
        if (request()->has('search')) {
            $checklist_category->where('name', 'like', '%' . request('search') . '%');
        }

        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // Get data
        $checklist_category = $checklist_category->paginate($perPage, ['*'], 'page', $page);

        // return json response
        return new ChecklistCategoryResource(true, 'Checklist Categories retrieved successfully', $checklist_category);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
