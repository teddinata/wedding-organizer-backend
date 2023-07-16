<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all user with request filter conditional
        $users = User::when(request('search'), function($users) {
            $users = $users->where('name', 'like', '%' . request('search') . '%');
        })->paginate(10);

        // return response
        return response()->json([
            'success' => true,
            'message' => 'List Semua User',
            'data' => $users
        ], 200);
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
        // set validation
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'roles' => 'required'
        ]);

        //  store data to database
        $user = User::create([
            'name' => $request->input('name'),
            'email' => strtolower($request->input('email')),
            'password' => bcrypt($request->input('password')),
            'created_by' => Auth::user()->id
        ]);

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
            return response()->json([
                'success' => true,
                'message' => 'User Berhasil Disimpan!',
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User Gagal Disimpan!',
            ], 400);
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
    public function update(Request $request, string $id)
    {
        // set validation
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'roles' => 'required'
        ]);

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
        $user->update([
            'updated_by' => Auth::user()->id
        ]);

        // acticity
        Activity::create([
            'log_name' => 'Edit User',
            'description' => 'User ' . Auth::user()->name . ' berhasil mengupdate user ' .  $user->name ,
            'subject_id' => $user->id,
            'subject_type' => 'App\Models\User'
        ]);


        // return response
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'User Berhasil Diupdate!',
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User Gagal Diupdate!',
            ], 500);
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
        $user->update([
            'deleted_by' => Auth::user()->id
        ]);

        // acticity
        Activity::create([
            'log_name' => 'Hapus User',
            'description' => 'User ' . Auth::user()->name . ' berhasil menghapus user ' .  $user->name ,
            'subject_id' => $user->id,
            'subject_type' => 'App\Models\User'
        ]);

        // return response
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'User Berhasil Dihapus!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User Gagal Dihapus!',
            ], 500);
        }
    }
}
