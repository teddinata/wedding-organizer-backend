<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class PermissionController extends Controller
{
    // function for show data permission
    public function index(Request $request)
    {
        // show data for permission with request filter conditional
        $query = Permission::query();

        if (request('search')) {
            $query->where('name', 'like', '%' . request('search') . '%');
        }

        // request sort asc or desc
        if (request('sort')) {
            $query->orderBy('name', request('sort'));
        }

        // request by id then show detail data, not array
        if ($request->has('id')) {
            $id = $request->input('id');
            $permission = $query->findOrFail($id);

            Activity::create([
                'log_name' => 'User ' . Auth::user()->name . ' show data permission detail ' . $permission->name,
                'description' => 'User ' . Auth::user()->name . ' show data permission detail ' . $permission->name,
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
                'message' => 'Detail Data Permission by id ' . $id,
                'data' => $permission
            ], 200);
        }

        // Get pagination settings
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        // Get data
        $permissions = $query->paginate($perPage, ['*'], 'page', $page);

        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' show data permission',
            'description' => 'User ' . Auth::user()->name . ' show data permission',
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
            'message' => 'List Data Permission',
            'data' => $permissions
        ]);
    }
}
