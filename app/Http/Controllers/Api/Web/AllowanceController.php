<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
// use resource
use App\Http\Resources\AllowanceResource;
// use model
use App\Models\MasterData\Allowance;
// request
use App\Http\Requests\Allowance\StoreAllowanceRequest;
use App\Http\Requests\Allowance\UpdateAllowanceRequest;

class AllowanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all allowances with filter and pagination
        $query = Allowance::orderBy('name', 'asc')->with(['department']);

        // filter by name and description in one search field
        if (request()->has('search')) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%');
            });
        }

        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // Get data
        $allowances = $query->paginate($perPage, ['*'], 'page', $page);

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' show data Allowance',
            'description' => 'User ' . Auth::user()->name . ' show data Allowance',
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
        return new AllowanceResource(true, 'Allowance retrieved successfully', $allowances);
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
    public function store(StoreAllowanceRequest $request)
    {
        // create new allowance
        $allowance = Allowance::create([
            'name' => $request->name,
            'department_id' => $request->department_id,
            'created_by' => Auth::user()->id,
        ] + $request->validated());

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' store data Allowance',
            'description' => 'User ' . Auth::user()->name . ' store data Allowance',
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
        return new AllowanceResource(true, 'Allowance created successfully', $allowance);
    }

    /**
     * Display the specified resource.
     */
    public function show(Allowance $allowance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Allowance $allowance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAllowanceRequest $request, Allowance $allowance)
    {
        // update allowance
        $allowance->update([
            'name' => $request->name,
            'department_id' => $request->department_id,
            'updated_by' => Auth::user()->id,
        ] + $request->validated());

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update data Allowance',
            'description' => 'User ' . Auth::user()->name . ' update data Allowance',
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
        return new AllowanceResource(true, 'Allowance updated successfully', $allowance);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find allowance
        $allowance = Allowance::findOrFail($id);

        // delete allowance
        $allowance->delete();

        // deleted by
        $allowance->deleted_by = Auth::user()->id;
        $allowance->save();

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete data Allowance',
            'description' => 'User ' . Auth::user()->name . ' delete data Allowance',
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
        return new AllowanceResource(true, 'Allowance deleted successfully', $allowance);
    }
}
