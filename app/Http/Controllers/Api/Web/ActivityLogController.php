<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Models\ActivityLog;
use App\Http\Resources\UserResource;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all activity logs with filter and pagination
        $query = ActivityLog::orderBy('created_at', 'desc');

        // filter by name and description in one search field
        if (request()->has('search')) {
            $query->where(function ($q) {
                $q->where('log_name', 'like', '%' . request('search') . '%')
                    ->orWhere('causer_type', 'like', '%' . request('search') . '%')
                    ->orWhere('description', 'like', '%' . request('search') . '%');
            });
        }

        // sort by name and created_at asc or desc
        if (request()->has('sort')) {
            $query->orderBy('log_name', request('sort'))
                ->orderBy('created_at', request('sort'));
        }

        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // Get data
        $activity_logs = $query->paginate($perPage, ['*'], 'page', $page);

        // return json response
        return new UserResource(true, 'Activity Log retrieved successfully', $activity_logs);
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
        // get activity log by id
        $activity_log = ActivityLog::findOrFail($id);

        // return json response
        return new UserResource(true, 'Detail Activity Log retrieved successfully', $activity_log);
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
