<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\Attendance;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all attendance with request filter conditional
        $query = Attendance::query();

        // filter by employee_id
        if (request()->has('employee_id')) {
            $query->where('employee_id', request('employee_id'));
        }

        // filter by date
        if (request()->has('date')) {
            $query->where('date', request('date'));
        }

        // filter by status ontime or late
        if (request()->has('status')) {
            $query->where('status', request('status'));
        }

        // filter by platform
        if (request()->has('platform')) {
            $query->where('platform', request('platform'));
        }

        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // Get data
        $attendances = $query->paginate($perPage, ['*'], 'page', $page);

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' show data Attendance',
            'description' => 'User ' . Auth::user()->name . ' show data Attendance',
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
        return response()->json([
            'success' => true,
            'message' => 'Attendances retrieved successfully.',
            'data' => $attendances
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
        // validate request
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'nullable|date',
            'clock_in' => 'nullable|date_format:H:i:s',
            'clock_out' => 'nullable|date_format:H:i:s',
            // photo
            'clock_in_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'clock_out_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // location
            'clock_in_location' => 'nullable|string|max:255',
            'clock_out_location' => 'nullable|string|max:255',
            // address
            'clock_in_address' => 'nullable|string|max:255',
            'clock_out_address' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        // upload photo
        $clock_in_photo = $request->file('clock_in_photo')->store('public/attendances');
        $clock_out_photo = $request->file('clock_out_photo')->store('public/attendances');

        // create attendance
        $attendance = Attendance::create([
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'clock_in' => $request->clock_in,
            'clock_in_photo' => $clock_in_photo,
            'clock_in_location' => $request->clock_in_location,
            'clock_in_address' => $request->clock_in_address,
            'clock_out' => $request->clock_out,
            'clock_out_photo' => $clock_out_photo,
            'clock_out_location' => $request->clock_out_location,
            'clock_out_address' => $request->clock_out_address,
            'status' => $request->status,
            'platform' => 'web',
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' create Attendance',
            'description' => 'User ' . Auth::user()->name . ' create Attendance',
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
        return response()->json([
            'success' => true,
            'message' => 'Attendance created successfully.',
            'data' => $attendance
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        // show summary detail attendance
        $summary = Attendance::where('employee_id', $attendance->employee_id)
            ->where('date', $attendance->date)
            ->get();

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' show detail Attendance',
            'description' => 'User ' . Auth::user()->name . ' show detail Attendance',
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
        return response()->json([
            'success' => true,
            'message' => 'Attendance retrieved successfully.',
            'data' => $attendance,
            'summary' => $summary
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        // validate request
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'nullable|date',
            'clock_in' => 'nullable|date_format:H:i:s',
            'clock_out' => 'nullable|date_format:H:i:s',
            // photo
            'clock_in_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'clock_out_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // location
            'clock_in_location' => 'nullable|string|max:255',
            'clock_out_location' => 'nullable|string|max:255',
            // address
            'clock_in_address' => 'nullable|string|max:255',
            'clock_out_address' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        // upload photo
        $clock_in_photo = $request->file('clock_in_photo')->store('public/attendances');
        $clock_out_photo = $request->file('clock_out_photo')->store('public/attendances');

        // update attendance
        $attendance->update([
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'clock_in' => $request->clock_in,
            'clock_in_photo' => $clock_in_photo,
            'clock_in_location' => $request->clock_in_location,
            'clock_in_address' => $request->clock_in_address,
            'clock_out' => $request->clock_out,
            'clock_out_photo' => $clock_out_photo,
            'clock_out_location' => $request->clock_out_location,
            'clock_out_address' => $request->clock_out_address,
            'status' => $request->status,
            'platform' => 'web',
            'updated_by' => Auth::user()->id,
        ]);

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update Attendance',
            'description' => 'User ' . Auth::user()->name . ' update Attendance',
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
        return response()->json([
            'success' => true,
            'message' => 'Attendance updated successfully.',
            'data' => $attendance
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find attendance
        $attendance = Attendance::findOrFail($id);

        // delete attendance
        $attendance->delete();

        // deleted by
        $attendance->update([
            'deleted_by' => Auth::user()->id,
        ]);

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete Attendance',
            'description' => 'User ' . Auth::user()->name . ' delete Attendance',
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
        return response()->json([
            'success' => true,
            'message' => 'Attendance deleted successfully.',
            'data' => $attendance
        ], 200);
    }
}