<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterData\AdditionalService;
use App\Http\Resources\Resource;
use App\Http\Requests\AdditionalService\StoreAdditionalServiceRequest;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;

class AdditionalServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all additional service
        $additionalServices = AdditionalService::query()->orderBy('name', 'asc')->get();

        // filter search by name
        if (request('search')) {
            $additionalServices = AdditionalService::query()
                ->where('name', 'like', '%' . request('search') . '%')
                ->orderBy('name', 'asc')
                ->get();
        }

        // sort by name asc or desc
        if (request('sort')) {
            $additionalServices = AdditionalService::query()
                ->orderBy('name', request('sort'))
                ->get();
        }

        // get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // get all data with paginate
        $additionalServices = AdditionalService::query()
            ->orderBy('name', 'asc')
            ->paginate($perPage, ['*'], 'page', $page);

        // return json response
        return new Resource(true, 'Additional Services retrieved successfully', $additionalServices);
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
    public function store(StoreAdditionalServiceRequest $request)
    {
        // create new additional service
        $additionalService = AdditionalService::create([
            'name' => $request->name,
            'created_by' => auth()->user()->id,
        ] + $request->validated());

        // logs
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' create data Additional Service',
            'description' => 'User ' . Auth::user()->name . ' create data Additional Service',
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
        return new Resource(true, 'Additional Service created successfully', $additionalService);
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
    public function update(StoreAdditionalServiceRequest $request, string $id)
    {
        // get data additional service by id
        $additionalService = AdditionalService::findOrFail($id);

        // update data
        $additionalService->update([
            'name' => $request->name,
            'updated_by' => auth()->user()->id,
        ] + $request->validated());

        // logs
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update data Additional Service',
            'description' => 'User ' . Auth::user()->name . ' update data Additional Service',
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
        return new Resource(true, 'Additional Service updated successfully', $additionalService);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // get data additional service by id
        $additionalService = AdditionalService::findOrFail($id);

        // delete data
        $additionalService->delete();

        // deleted by
        $additionalService->deleted_by = auth()->user()->id;
        $additionalService->save();

        // logs
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete data Additional Service',
            'description' => 'User ' . Auth::user()->name . ' delete data Additional Service',
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
        return new Resource(true, 'Additional Service deleted successfully', $additionalService);
    }
}
