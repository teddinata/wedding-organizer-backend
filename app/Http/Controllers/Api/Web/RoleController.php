<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);
        // show data for role with request filter conditional
        $roles = Role::when(request('search'), function($roles) {
            $roles = $roles->where('name', 'like', '%' . request('search') . '%');
        })->paginate($perPage, ['*'], 'page', $page);

        // activity()
        // ->causedBy(Auth::user())
        // ->log('User ' . Auth::user()->name . ' show data role');

        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' show data role',
            'description' => 'User ' . Auth::user()->name . ' show data role',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'List Data Role',
            'data' => $roles
        ]);
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
        // validate request
        $this->validate($request, [
            'name' => 'required',
            'permissions' => 'required'
        ]);

        // create role
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        // assign give permission to role
        $role->givePermissionTo($request->permissions);

        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' create data role',
            'description' => 'User ' . Auth::user()->name . ' create data role',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return response
        return response()->json([
            'success' => true,
            'message' => 'Role saved successfully.',
            'data' => $role
        ]);
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
        // validate request
        $this->validate($request, [
            'name' => 'required',
            'permissions' => 'required'
        ]);

        // find role by id
        $role = Role::findOrFail($id);

        // update role
        $role->update([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        // sync permission to role
        $role->syncPermissions($request->permissions);

        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update data role',
            'description' => 'User ' . Auth::user()->name . ' update data role',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return response
        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully.',
            'data' => $role
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // find role by id
        $role = Role::findOrFail($id);

        // delete role
        $role->delete();

        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete data role',
            'description' => 'User ' . Auth::user()->name . ' delete data role',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return response
        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully.',
            'data' => $role
        ]);
    }
}
