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
            // Jika validasi berhasil, Anda dapat melanjutkan dengan menyimpan data Membership ke database.
            $membershipData = [
                'name' => $request->input('name'),
                'from' => $request->input('from'),
                'until' => $request->input('until'),
                'point' => $request->input('point'),
            ];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = 'membership' . '_' . rand(100000, 999999) . '_' . str_replace(' ', '_', $image->getClientOriginalName());

                $path = $image->storeAs('uploads/membership', $filename, 'public');

                if ($path) {
                    $membershipData['image'] = $filename;
                }
            }

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
            $membershipData = [
                'name' => $request->input('name'),
                'from' => $request->input('from'),
                'until' => $request->input('until'),
                'point' => $request->input('point'),
            ];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = 'membership' . '_' . rand(100000, 999999) . '_' . str_replace(' ', '_', $image->getClientOriginalName());

                $path = $image->storeAs('uploads/membership', $filename, 'public');

                if ($path) {
                    $membershipData['image'] = $filename;
                }
            }

            $membership->update($membershipData + $request->validated());

            // activity log
            activity('updated')
                ->performedOn($membership)
                ->causedBy(Auth::user());

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
