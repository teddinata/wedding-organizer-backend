<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        // Validasi input user
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        // Cek credential login
        if (Auth::attempt($request->only('email', 'password'))) {
            // Jika credential benar, maka buat token
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('token')->plainTextToken;

            // activity log
            activity()
            ->causedBy(Auth::user())
            ->log('User logged in');

            // Kirim token ke user
            return response()->json([
                'message'   => 'You have been successfully logged in!',
                // data user with roles
                'token'     => $token,
                'user'      => $user->load('roles')
            ], 200);
        }
    }

    // logout
    public function logout(Request $request)
    {
        // Cek apakah user sudah login
        if (Auth::user()) {
            // Hapus token yang dimiliki user
            Auth::user()->tokens()->delete();

            activity()
            ->causedBy(Auth::user())
            ->log('User logged out');

            // Kirim pesan ke user
            return response()->json([
                'message'   => 'You have been successfully logged out!'
            ], 200);
        }
    }
}
