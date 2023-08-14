<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\DecorationArea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class DecorationAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'name' => 'required|string',
        ]);

        // create decoration area
        $decorationArea = DecorationArea::create([
            'name' => $request->name,
            // 'created_by' => Auth::user()->id,
        ]);

        // logs
         // log activity
         Activity::create([
            'log_name' => 'User ' . Auth::user()->name . ' store data Decoration Area',
            'description' => 'User ' . Auth::user()->name . ' store data Decoration Area',
            'subject_id' => Auth::user()->id,
            'subject_type' => 'App\Models\User',
            'causer_id' => Auth::user()->id,
            'causer_type' => 'App\Models\User',
            'properties' => request()->ip(),
            // 'host' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return response
        return response()->json([
            'success' => true,
            'message' => 'Decoration area created successfully.',
            'data' => $decorationArea
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(DecorationArea $decorationArea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DecorationArea $decorationArea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DecorationArea $decorationArea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DecorationArea $decorationArea)
    {
        //
    }
}
