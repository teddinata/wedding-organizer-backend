<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
// use db
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all employees with filter and pagination
        $query = Employee::query();

        // filter by name or nik or email in one search field
        if (request()->has('search')) {
            $query->where('fullname', 'like', '%' . request('search') . '%')
                ->orWhere('nik', 'like', '%' . request('search') . '%')
                ->orWhere('email', 'like', '%' . request('search') . '%');
        }

        // filter by department
        if (request()->has('department_id')) {
            $query->where('department_id', request('department_id'));
        }

        // filter by position
        if (request()->has('position_id')) {
            $query->where('position_id', request('position_id'));
        }

        // filter by level
        if (request()->has('level_id')) {
            $query->where('level_id', request('level_id'));
        }

        // get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        // get data
        $employees = $query->paginate($perPage, ['*'], 'page', $page);

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' show data Employee',
            'description' => 'User ' . Auth::user()->name . ' show data Employee',
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
            'message' => 'Employees retrieved successfully.',
            'data' => $employees
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
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'level_id' => 'required|exists:levels,id',
            'fullname' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'dateofbirth' => 'nullable|date',
            'gender' => 'nullable|in:1,2',
            'ktp_img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'vaccine_img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'salary' => 'nullable|numeric',
            'loan_limit' => 'nullable|numeric',
            'active_loan_limit' => 'nullable|numeric',
            'points' => 'nullable|numeric',
            'is_active' => 'nullable|boolean',
        ]);

        // create employee use eloquent
        $employee = new Employee();
        $employee->department_id = $request->input('department_id');
        $employee->position_id = $request->input('position_id');
        $employee->level_id = $request->input('level_id');
        $employee->fullname = $request->input('fullname');
        $employee->nik = $request->input('nik');
        $employee->email = $request->input('email');
        $employee->password = bcrypt($request->input('password'));
        $employee->photo = $request->file('photo') ? $request->file('photo')->store('photos') : null;
        $employee->dateofbirth = $request->input('dateofbirth');
        $employee->gender = $request->input('gender');
        $employee->ktp_img = $request->file('ktp_img') ? $request->file('ktp_img')->store('ktp_images') : null;
        $employee->vaccine_img = $request->file('vaccine_img') ? $request->file('vaccine_img')->store('vaccine_images') : null;
        $employee->salary = $request->input('salary');
        $employee->loan_limit = $request->input('loan_limit');
        $employee->active_loan_limit = $request->input('active_loan_limit');
        $employee->points = $request->input('points');
        $employee->is_active = $request->input('is_active', false); // Default value is false if not provided
        $employee->created_by = Auth::user()->id;
        $employee->save();

        // logs
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' create data Employee',
            'description' => 'User ' . Auth::user()->name . ' create data Employee',
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
            'message' => 'Employee created successfully.',
            'data' => $employee
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        // show detail employee
        $employee = Employee::with('department', 'position', 'level')->findOrFail($employee->id);

        // return json response
        return response()->json([
            'success' => true,
            'message' => 'Employee retrieved successfully.',
            'data' => $employee
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // validate request
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'level_id' => 'required|exists:levels,id',
            'fullname' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'email_verified_at' => 'nullable|date',
            'password' => 'nullable|string|confirmed',
            'otp' => 'nullable|string|max:255',
            'otp_verified_at' => 'nullable|date',
            'reset_token' => 'nullable|string|max:255',
            'notification_token' => 'nullable|string|max:255',
            'dateofbirth' => 'nullable|date',
            'gender' => 'nullable|in:1,2',
            'ktp_img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'vaccine_img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'salary' => 'nullable|numeric',
            'loan_limit' => 'nullable|numeric',
            'active_loan_limit' => 'nullable|numeric',
            'points' => 'nullable|numeric',
            'is_active' => 'nullable|boolean',
        ]);

        $employee = Employee::findOrFail($id);

        $employee->department_id = $request->input('department_id');
        $employee->position_id = $request->input('position_id');
        $employee->level_id = $request->input('level_id');
        $employee->fullname = $request->input('fullname');
        $employee->nik = $request->input('nik');
        $employee->email = $request->input('email');
        $employee->email_verified_at = $request->input('email_verified_at');
        $employee->otp = $request->input('otp');
        $employee->otp_verified_at = $request->input('otp_verified_at');
        $employee->reset_token = $request->input('reset_token');
        $employee->notification_token = $request->input('notification_token');
        $employee->dateofbirth = $request->input('dateofbirth');
        $employee->gender = $request->input('gender');
        $employee->salary = $request->input('salary');
        $employee->loan_limit = $request->input('loan_limit');
        $employee->active_loan_limit = $request->input('active_loan_limit');
        $employee->points = $request->input('points');
        $employee->is_active = $request->input('is_active');

        if ($request->hasFile('photo')) {
            $employee->photo = $request->file('photo')->store('photos');
        }

        if ($request->hasFile('ktp_img')) {
            $employee->ktp_img = $request->file('ktp_img')->store('ktp');
        }

        if ($request->hasFile('vaccine_img')) {
            $employee->vaccine_img = $request->file('vaccine_img')->store('vaccine');
        }

        $employee->save();

        // Log activity\
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update data Employee',
            'description' => 'User ' . Auth::user()->name . ' update data Employee',
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
            'message' => 'Employee updated successfully.',
            'data' => $employee
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        // Log activity\
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' delete data Employee',
            'description' => 'User ' . Auth::user()->name . ' delete data Employee',
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
            'message' => 'Employee deleted successfully.',
            'data' => $employee
        ], 200);
    }

    /**
     * Generate a random password.
     *
     * @param  int  $length
     * @return string
     */
    private function generatePassword($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';
        $characterCount = strlen($characters);

        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, $characterCount - 1)];
        }

        return $password;
    }

    /**
     * Generate user account for the employee.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateUserAccount($id)
    {
        // Find the employee by ID
        $employee = Employee::findOrFail($id);

        // Generate a random password for the user account
        $password = $this->generatePassword();

        // Create user account with employee data and generated password
        $user = new User([
            'name' => $employee->fullname,
            'email' => $employee->email,
            'password' => Hash::make($password),
        ]);

        // Save the user account
        $employee->user()->save($user);

        // Create JSON data with the generated password
        $jsonData = [
            'employee_id' => $employee->id,
            'email' => $employee->email,
            'password' => $password,
            'generated_at' => now()->toDateTimeString(),
        ];

        // Convert the data to JSON format
        $jsonData = json_encode($jsonData);

        // Save the JSON data to a file (you can change the file name as needed)
        $fileName = "generated_passwords/employee_{$employee->id}.json";
        Storage::put($fileName, $jsonData);

        return response()->json([
            'success' => true,
            'message' => 'User account has been created for the employee.',
            'user' => $user,
        ]);
    }
}
