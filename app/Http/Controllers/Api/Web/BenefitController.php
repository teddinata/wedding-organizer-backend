<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;
// use resource
use App\Http\Resources\Benefit\BenefitCollection;
use App\Http\Resources\Benefit\BenefitResource;
// use model
use App\Models\MasterData\Benefit;
// request
use App\Http\Requests\Benefit\StoreBenefitRequest;
use App\Http\Requests\Benefit\UpdateBenefitRequest;

class BenefitController extends Controller
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
            $query = Benefit::where('name', 'like', '%' . $search . '%')->get();
        } else {
            // get benefit data and sort by name ascending
            $query = Benefit::orderBy('name', 'asc')->get();
        }

        foreach ($query as $benefit) {
            $benefit->image = asset('storage/uploads/benefit/' . $benefit->image);
        }

        //return resource collection
        $showData = new BenefitCollection(true, 'Benefit retrieved successfully', $query);
        return  $showData->paginate($perPage, $page);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBenefitRequest $request)
    {
        try {
            // Jika validasi berhasil, Anda dapat melanjutkan dengan menyimpan data benefit ke database.
            $benefitData = [
                'name' => $request->input('name'),
                'is_publish' => $request->input('is_publish', true),
            ];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = 'benefit' . '_' . rand(100000, 999999) . '_' . str_replace(' ', '_', $image->getClientOriginalName());

                $path = $image->storeAs('uploads/benefit', $filename, 'public');

                if ($path) {
                    $benefitData['image'] = $filename;
                }
            }

            $benefit = Benefit::create($benefitData + $request->validated());

            // activity log
            activity('created')
                ->performedOn($benefit)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new BenefitResource($benefit), $benefit->name . ' has been created successfully.');
        } catch (\Throwable $th) {
            return $this->errorResponse('Data failed to save. Please try again!');
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
     * Update the specified resource in storage.
     */
    public function update(UpdateBenefitRequest $request, Benefit $benefit)
    {
        try {
            // update benefit like store() method above
            $benefitData = [
                'name' => $request->input('name'),
                'is_publish' => $request->input('is_publish'),
            ];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = 'benefit' . '_' . rand(100000, 999999) . '_' . str_replace(' ', '_', $image->getClientOriginalName());

                $path = $image->storeAs('uploads/benefit', $filename, 'public');

                if ($path) {
                    $benefitData['image'] = $filename;
                }
            }

            $benefit->update($benefitData + $request->validated());

            // activity log
            activity('updated')
                ->performedOn($benefit)
                ->causedBy(Auth::user());

            // return JSON response
            return $this->successResponse(new BenefitResource($benefit), 'Changes has been successfully saved.');
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'An error occurred. Data failed to update!'], 409);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // find data
        $query = Benefit::findOrFail($id);
        $query->delete();
        $query->save();

        // activity log
        activity('deleted')
            ->performedOn($query)
            ->causedBy(Auth::user());

        // return JSON response
        return $this->successResponse(new BenefitResource($query), $query->name . ' has been deleted successfully.');
    }
}
