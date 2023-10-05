<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
// use resource
use App\Http\Resources\CareerLevelResource;
// model
use App\Models\MasterData\CareerLevel;
use Illuminate\Http\Request;

class CareerLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // get career level data and sort by name ascending
        $query = CareerLevel::orderBy('description', 'asc')->paginate($perPage, ['*'], 'page', $page);

        //return collection of area as a resource
        return CareerLevelResource::collection($query);
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
