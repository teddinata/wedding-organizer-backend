<?php

namespace App\Http\Controllers\Api\Web;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
// resource
use App\Http\Resources\Membership\MembershipCollection;
use App\Http\Resources\Membership\MembershipResource;
// model
use App\Models\MasterData\Membership;
// request
use App\Http\Requests\Membership\StoreMembershipRequest;
use App\Http\Requests\Membership\UpdateMembershipRequest;

class MembershipController extends Controller
{
    // use traits for success and error JSON response
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get pagination settings
        $perPage = request('per_page', 10);
        $page = request('page', 1);

        //set variable for search
        $search = $request->query('search');

        //set condition if search not empty then find by name else then show all data
        if (!empty($search)) {
            $query = Membership::where('name', 'like', '%' . $search . '%')->get();
        } else {
            // get checklist item data and sort by name ascending
            $query = Membership::orderBy('from', 'asc')->get();
        }

        foreach ($query as $membership) {
            $membership->image = asset('storage/uploads/membership/' . $membership->image);
        }

        //return resource collection
        $showData = new MembershipCollection(true, 'Membership retrieved successfully', $query);
        return  $showData->paginate($perPage, $page);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMembershipRequest $request)
    {
        try {
            // check from harus lebih besar dari until di membership lain yang sudah ada di database dan tidak boleh sama dengan until di level lain yang sudah ada di database dan cek request from dan until tidak boleh sama
            $fromCheck = Membership::where('from', '>=', $request->from)->first();
            $untilCheck = Membership::where('until', '>=', $request->until)->first();
            $fromEqualCheck = Membership::where('from', '=', $request->from)->first();
            $untilEqualCheck = Membership::where('until', '=', $request->until)->first();

            if ($fromCheck) {
                // return $this->errorResponse('From must be greater than the previous level: ' . $fromCheck->name);
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'data' => [
                        'from' => ['From must be greater than the previous membership: ' . $fromCheck->name]
                    ]
                ], 409);
            }

            if ($untilCheck) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'data' => [
                        'until' => ['Until must be greater than the previous membership: ' . $untilCheck->name]
                    ]
                ], 409);
            }

            if ($fromEqualCheck) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'data' => [
                        'from' => ['From cannot be the same as the previous membership: ' . $fromEqualCheck->name]
                    ]
                ], 409);
            }

            if ($untilEqualCheck) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'data' => [
                        'until' => ['Until cannot be the same as the previous membership: ' . $untilEqualCheck->name]
                    ]
                ], 409);
            }

           // Persiapkan data Membership
            $membershipData = [
                'name' => $request->name,
                'from' => $request->from,
                'until' => $request->until,
                'point' => $request->input('point'),
            ] + $request->validated();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = 'membership' . '_' . rand(100000, 999999) . '_' . str_replace(' ', '_', $image->getClientOriginalName());

                $path = $image->storeAs('uploads/membership', $filename, 'public');

                if ($path) {
                    $membershipData['image'] = $filename;
                }
            }

            // Buat entitas Membership
            $membership = Membership::create($membershipData + $request->validated());

            // activity log
            activity('created')
                ->performedOn($membership)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new MembershipResource($membership), $membership->name . ' has been created successfully.');
        } catch (\Throwable $th) {
            return $this->errorResponse('Data failed to save. Please try again!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Membership $membership)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMembershipRequest $request, Membership $membership)
    {
        try {

            // update membership like store() method above
             // Pengecekan 'from' dan 'until'
            $fromCheck = Membership::where('from', '>', $request->from)->where('id', '!=', $membership->id)->first();
            $untilCheck = Membership::where('until', '>', $request->until)->where('id', '!=', $membership->id)->first();
            $fromEqualCheck = Membership::where('from', '=', $request->from)->where('id', '!=', $membership->id)->first();
            $untilEqualCheck = Membership::where('until', '=', $request->until)->where('id', '!=', $membership->id)->first();

            if ($fromCheck) {
                // return $this->errorResponse('From must be greater than the previous level: ' . $fromCheck->name);
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'data' => [
                        'from' => ['From must be greater than the previous membership: ' . $fromCheck->name]
                    ]
                ], 409);
            }

            if ($untilCheck) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'data' => [
                        'until' => ['Until must be greater than the previous membership: ' . $untilCheck->name]
                    ]
                ], 409);
            }

            if ($fromEqualCheck) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'data' => [
                        'from' => ['From cannot be the same as the previous membership: ' . $fromEqualCheck->name]
                    ]
                ], 409);
            }

            if ($untilEqualCheck) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'data' => [
                        'until' => ['Until cannot be the same as the previous membership: ' . $untilEqualCheck->name]
                    ]
                ], 409);
            }

            // Persiapkan data Membership
            $membershipData = [
                'name' => $request->name,
                'from' => $request->from,
                'until' => $request->until,
                'point' => $request->input('point'),
            ] + $request->validated();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = 'membership' . '_' . rand(100000, 999999) . '_' . str_replace(' ', '_', $image->getClientOriginalName());

                $path = $image->storeAs('uploads/membership', $filename, 'public');

                if ($path) {
                    $membershipData['image'] = $filename;
                }
            }

            // Perbarui data Membership
            $membership->update($membershipData);

            // Activity Log
            activity('updated')
                ->performedOn($membership)
                ->causedBy(Auth::user())
                ->log('Membership updated');

            // return JSON response
            return $this->successResponse(new MembershipResource($membership), 'Changes has been successfully saved.');
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'An error occurred. Data failed to update!'], 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find membership
        $query = Membership::findOrFail($id);
        $query->delete();
        $query->save();

        // activity log
        activity('deleted')
            ->performedOn($query)
            ->causedBy(Auth::user());

        // return JSON response
        return $this->successResponse(new MembershipResource($query), $query->name . ' has been deleted successfully.');
    }
}
