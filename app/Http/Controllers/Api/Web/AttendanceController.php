<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\Operational\Attendance;
use App\Models\MasterData\Employee;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use App\Http\Resources\AttendanceResource;
// request
use App\Http\Requests\Attendance\StoreAttendanceRequest;
use App\Http\Requests\Attendance\UpdateAttendanceRequest;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all attendance with request filter conditional
        $query = Attendance::orderBy('date', 'desc')->with(['employee']);

        // filter search by every column
        if (request()->has('search')) {
            $query->where('employee_id', request('search'))
                ->orWhere('date', 'like', '%' . request('search') . '%')
                ->orWhere('clock_in', 'like', '%' . request('search') . '%')
                ->orWhere('clock_out', 'like', '%' . request('search') . '%')
                ->orWhere('platform', 'like', '%' . request('search') . '%');
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
        return new AttendanceResource(true, 'Attendance retrieved successfully', $attendances);
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
    public function store(StoreAttendanceRequest $request)
    {
        // Mengambil data employee
        $employee = Employee::where('id', $request->employee_id)->first();

        // pengecekan apakah dalam satu hari ada lebih dari satu jam masuk
        $checkClockIn = Attendance::where('employee_id', $request->employee_id)
            ->where('date', $request->date)
            ->where('clock_in', '!=', null)
            ->first();

        if ($checkClockIn) {
            return new AttendanceResource(false, 'You have already clocked in this day!', null);
        }

        // Mengambil jam masuk yang ditetapkan oleh departemen karyawan
        $departmentClockIn = $employee->department->clock_in; // Anda perlu mengganti ini dengan atribut yang sesuai
        // dd($departmentClockIn);

        // Mengambil jam masuk dari request
        // $clockIn = Carbon::parse($request->clock_in); // Pastikan Anda menggunakan library Carbon atau sejenisnya
        $clockIn = $request->clock_in; // Pastikan Anda menggunakan library Carbon atau sejenisnya
        // dd($clockIn < $departmentClockIn);

        // Membandingkan jam masuk dengan jam masuk departemen
        if ($clockIn > $departmentClockIn) {
            $status = 2;
        } else {
            $status = 1;
        }

        // create attendance
        $attendance = Attendance::create([
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'clock_in' => $request->clock_in,
            'clock_out' => $request->clock_out,
            'platform' => 'web',
            'status' => $status,
            'created_by' => Auth::user()->id,
        ] + $request->validated());

        // status 1 = on time (tepat waktu) dan status 2 = late (terlambat)
        if ($status == 1){
            $attendance->on_time = "YES! YOU ARE ON TIME! KEEP UP THE GOOD WORK!";
        } else {
            $attendance->on_time = "NO!!! YOU ARE LATE!";
        }

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
        return new AttendanceResource(true, 'Attendance created successfully', $attendance);
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
        return new AttendanceResource(true, 'Detail Attendance retrieved successfully', $summary);
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
    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        // Mengambil data employee
        $employee = Employee::where('id', $request->employee_id)->first();

        // pengecekan apakah dalam satu hari ada lebih dari satu jam masuk
        $checkClockIn = Attendance::where('employee_id', $request->employee_id)
            ->where('date', $request->date)
            ->where('clock_in', '!=', null)
            ->first();

        if ($checkClockIn) {
            return new AttendanceResource(false, 'You have already clocked in this day!', null);
        }

        // Mengambil jam masuk yang ditetapkan oleh departemen karyawan
        $departmentClockIn = $employee->department->clock_in; // Anda perlu mengganti ini dengan atribut yang sesuai
        // dd($departmentClockIn);

        // Mengambil jam masuk dari request
        // $clockIn = Carbon::parse($request->clock_in); // Pastikan Anda menggunakan library Carbon atau sejenisnya
        $clockIn = $request->clock_in; // Pastikan Anda menggunakan library Carbon atau sejenisnya
        // dd($clockIn);

        // Membandingkan jam masuk dengan jam masuk departemen
        if ($clockIn > $departmentClockIn) {
            $status = 2;
        } else {
            $status = 1;
        }

        // update attendance
        $attendance->update([
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'clock_in' => $request->clock_in,
            'clock_out' => $request->clock_out,
            'platform' => 'web',
            'status' => $status,
            'updated_by' => Auth::user()->id,
        ] + $request->validated());

        // status 1 = on time (tepat waktu) dan status 2 = late (terlambat)
        if ($status == 1){
            $attendance->on_time = "YES! YOU ARE ON TIME! KEEP UP THE GOOD WORK!";
        } else {
            $attendance->on_time = "NO!!! YOU ARE LATE!";
        }

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
        return new AttendanceResource(true, 'Attendance updated successfully', $attendance);
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
        $attendance->deleted_by = Auth::user()->id;
        $attendance->save();

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
        return new AttendanceResource(true, 'Attendance deleted successfully', $attendance);
    }
}
