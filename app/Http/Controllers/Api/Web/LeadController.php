<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use App\Models\Operational\Lead;
use App\Models\MasterData\VendorGrade;
use App\Models\Operational\Vendor;
use App\Http\Requests\Lead\LeadRequest;
use App\Http\Requests\Lead\UpdateLeadRequest;


class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get all lead with filter and pagination
        $query = Vendor::where('vendor_grade_id', $request->vendor_grade_id)->with(['leads']);

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
        $leads = $query->paginate($perPage, ['*'], 'page', $page);

        // count total vendor grade
        $totalVendor = Vendor::where('vendor_grade_id', $request->vendor_grade_id)->count();

        // count total follow up this month
        $totalFollowUp = Lead::where('vendor_id', $request->vendor_grade_id)->whereMonth('date', date('m'))->count();

        // count total response yes
        $totalResponseYes = Lead::where('vendor_id', $request->vendor_grade_id)->where('response', 'yes')->count();

        // count total response no
        $totalResponseNo = Lead::where('vendor_id', $request->vendor_grade_id)->where('response', 'no')->count();

        // log activity
        // Activity::create([
        //     'log_name' => 'User ' . Auth::user()->name . ' show data Lead',
        //     'description' => 'User ' . Auth::user()->name . ' show data Lead',
        //     'subject_id' => Auth::user()->id,
        //     'subject_type' => 'App\Models\User',
        //     'causer_id' => Auth::user()->id,
        //     'causer_type' => 'App\Models\User',
        //     'properties' => request()->ip(),
        //     // 'host' => request()->ip(),
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);

        // return json response
        return response()->json([
            'success' => true,
            'message' => 'Lead retrieved successfully',
            'total_vendor' => $totalVendor,
            'total_follow_up_this_month' => $totalFollowUp,
            'total_response_yes' => $totalResponseYes,
            'total_response_no' => $totalResponseNo,
            'data' => $leads,
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
    public function store(LeadRequest $request)
    {
        // create new lead
        $lead = Lead::create([
            'vendor_id' => $request->vendor_id,
            'date' => now(),
            'pic' => Auth::user()->name,
            'response' => $request->response,
            'code' => $request->code,
            'note' => $request->note,
            'created_by' => Auth::user()->id,
        ] + $request->validated());

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' create data Lead',
            'description' => 'User ' . Auth::user()->name . ' create data Lead',
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
        return new Resource(true, 'Lead created successfully', $lead);
    }

    // detail leads function
    public function detailLeads(Request $request)
    {
        // get all
        $query = Vendor::where('vendor_id', $request->vendor_id)->with(['leads']);

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
        $leads = $query->paginate($perPage, ['*'], 'page', $page);

        // log activity
        // Activity::create([
        //     'log_name' => 'User ' . Auth::user()->name . ' show data Lead',
        //     'description' => 'User ' . Auth::user()->name . ' show data Lead',
        //     'subject_id' => Auth::user()->id,
        //     'subject_type' => 'App\Models\User',
        //     'causer_id' => Auth::user()->id,
        //     'causer_type' => 'App\Models\User',
        //     'properties' => request()->ip(),
        //     // 'host' => request()->ip(),
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);

        // return json response
        return response()->json([
            'success' => true,
            'message' => 'Lead retrieved successfully',
            'data' => $leads,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // get all
        $query = Lead::where('vendor_id', $id);

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
        $leads = $query->paginate($perPage, ['*'], 'page', $page);

        // log activity
        // Activity::create([
        //     'log_name' => 'User ' . Auth::user()->name . ' show data Lead',
        //     'description' => 'User ' . Auth::user()->name . ' show data Lead',
        //     'subject_id' => Auth::user()->id,
        //     'subject_type' => 'App\Models\User',
        //     'causer_id' => Auth::user()->id,
        //     'causer_type' => 'App\Models\User',
        //     'properties' => request()->ip(),
        //     // 'host' => request()->ip(),
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);

        // return json response
        return response()->json([
            'success' => true,
            'message' => 'Detail Lead by vendor id retrieved successfully',
            'data' => $leads,
        ]);
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
    public function update(UpdateLeadRequest $request, string $id)
    {
        // update lead
        $lead = Lead::findOrFail($id);

        // update lead
        $lead->update([
            'vendor_id' => $lead->vendor_id ? $lead->vendor_id : $request->vendor_id,
            'date' => now(),
            'pic' => Auth::user()->name,
            'response' => $lead->response ? $lead->response : $request->response,
            'code' => $lead->code ? $lead->code : $request->code,
            'note' => $lead->note ? $lead->note : $request->note,
            'updated_by' => Auth::user()->id,
        ] + $request->validated());

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' update data Lead',
            'description' => 'User ' . Auth::user()->name . ' update data Lead',
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
        return new Resource(true, 'Lead updated successfully', $lead);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // find lead by id
        $lead = Lead::findOrFail($id);

        // delete lead
        $lead->delete();

        // soft delete to database
        $lead->deleted_by = Auth::user()->id;
        $lead->save();

        // log activity
        Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' deleted data Lead',
            'description' => 'User ' . Auth::user()->name . ' deleted data Lead',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return new Resource(true, 'Lead deleted successfully', $lead);
    }
}
