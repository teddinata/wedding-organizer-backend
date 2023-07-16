<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProtectedController extends Controller
{
    //
    public function admin(Request $request)
    {
        return response()->json(['message' => 'Admin resource accessed successfully'], 200);
    }
}
