<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Reset password link sent to your email'], 200)
            : response()->json(['message' => 'Unable to send reset password link'], 400);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => 'Password reset successfully'], 200)
            : response()->json(['message' => 'Unable to reset password'], 400);
    }
}
