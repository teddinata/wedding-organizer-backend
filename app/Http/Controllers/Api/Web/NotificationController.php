<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;
// model
use App\Models\Notification;
// resource
use App\Http\Resources\Notification\NotificationCollection;
// use App\Http\Resources\Notification\NotificationResource;


class NotificationController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // get grade data and sort by id ascending
        $query = Notification::orderBy('id', 'desc')->with('user')->get();

        // request by id then show detail data, not array
        if ($request->has('id')) {
            $id = $request->input('id');

            // find the data by id
            $query = Notification::findOrFail($id);

            //return JSON response
            return $this->successResponse($query, 'Data found.');
        }

        //return resource collection
        $showData = new NotificationCollection(true, 'Notification retrieved successfully', $query);
        return  $showData->paginate($perPage, $page);
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
