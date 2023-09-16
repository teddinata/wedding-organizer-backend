<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // get all user with request filter conditional
        $users = User::when(request('search'), function($users) {
            $users = $users->where('name', 'like', '%' . request('search') . '%')
                            ->orWhere('email', 'like', '%' . request('search') . '%');
        })->paginate($perPage, ['*'], 'page', $page);

        // return response
        return new UserResource(true, 'Users retrieved successfully', $users);
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
    public function store(StoreUserRequest $request)
    {
        //  store data to database
        $user = User::create([
            'name' => $request->input('name'),
            'email' => strtolower($request->input('email')),
            'password' => bcrypt($request->input('password')),
            'created_by' => Auth::user()->id
        ] + $request->validated());

        // assign role to user
        $user->assignRole($request->input('roles'));

        // acticity
        Activity::create([
            'log_name' => 'Tambah User',
            'description' => 'User ' . Auth::user()->name . ' berhasil menambahkan user ' .  $user->name ,
            'subject_id' => $user->id,
            'subject_type' => 'App\Models\User'
        ]);

        // return response
        if ($user) {
            return new UserResource(true, 'User data saved successfully', $user);
        } else {
            return new UserResource(false, 'User data failed to save', null);
        }
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
    public function update(UpdateUserRequest $request, string $id)
    {
        // get data user by id
        $user = User::findOrFail($id);

        // check if password not empty then change password
        if ($request->input('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // update user
        $user->update($request->except('password'));

        // delete role user
        $user->roles()->detach();

        // assign role to user
        $user->assignRole($request->input('roles'));

        // update updated_by on table users
        $user->updated_by = Auth::user()->id;
        $user->save();

        // acticity
        Activity::create([
            'log_name' => 'Edit User',
            'description' => 'User ' . Auth::user()->name . ' berhasil mengupdate user ' .  $user->name ,
            'subject_id' => $user->id,
            'subject_type' => 'App\Models\User'
        ]);

        // return response
        if ($user) {
            return new UserResource(true, 'User data updated successfully', $user);
        } else {
            return new UserResource(false, 'User data failed to update', null);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // get data user by id
        $user = User::findOrFail($id);

        // delete user
        $user->delete();
        $user->roles()->detach();

        // update deleted_by on table users
        $user->deleted_by = Auth::user()->id;
        $user->save();

        // acticity
        Activity::create([
            'log_name' => 'Hapus User',
            'description' => 'User ' . Auth::user()->name . ' berhasil menghapus user ' .  $user->name ,
            'subject_id' => $user->id,
            'subject_type' => 'App\Models\User'
        ]);

        // return response
        if ($user) {
            return new UserResource(true, 'User data deleted successfully', $user);
        } else {
            return new UserResource(false, 'User data failed to delete', null);
        }
    }
}
