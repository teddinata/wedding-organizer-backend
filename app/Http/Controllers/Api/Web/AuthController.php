<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Mail\OtpEmail;
use App\Mail\EmailVerification;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Otp;


class AuthController extends Controller
{
    private $otp;

    public function __construct(Otp $Otp)
        {
            $this->otp = $Otp;
        }

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
            $user->last_login = now();
            $user->save();

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
        } else {
            // Jika credential salah, maka kirim pesan error
            return response()->json([
                'message'   => 'Invalid login credentials!'
            ], 401);
        }
    }

    // edit profile
    public function editProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required|numeric',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        // get user login
        $user = Auth::user();

        // update user
        $user->update($request->except('photo'));

        // update photo
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = 'profile' . '_' . rand(100000, 999999) . '_' . str_replace(' ', '_', $photo->getClientOriginalName());

            $path = $photo->storeAs('uploads/profile', $filename, 'public');

            if ($path) {
                $user->profile_photo_path = $filename;
                $user->save();
            }
        }

        $user->profile_photo_path = $user->profile_photo_path ? asset('storage/uploads/profile/' . $user->profile_photo_path) : null;

        // return response
        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user
        ], 200);
    }

    // verif email
    public function verifEmail(Request $request)
    {
        // first send otp to email existing from auth user
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // generate otp 5 digit alphabet and number
        $otp = strtoupper(Str::random(5));

        // save otp to database
        $user->otp = $otp;
        $user->otp_expiry = now()->addDays(3);
        $user->save();
        // jika hari ini sudah melebihi 3 hari, maka hapus otp dan otp expiry
        if ($user->otp_expiry < now()) {
            $user->otp = null;
            $user->otp_expiry = null;
        }

        // send otp to user
        Mail::to($user->email)->send(new EmailVerification($user, $otp));

        if ($user->save()) {
            return response()->json(['message' => 'OTP successfully sent to your email!'], 200);
        } else {
            return response()->json(['message' => 'Unable to send OTP'], 400);
        }
    }

    // confirm verif email
    public function confirmVerifEmail(Request $request)
    {
        $request->validate([
            'otp' => 'required',
        ]);

        $user = Auth::user();

        if (!$user || $user->otp !== $request->otp) {
            return response()->json(['message' => 'Your Verification Code is invalid. Please try again'], 400);
        }

        if ($user->otp_expiry <= now()) {
            return response()->json(['message' => 'Your Verification Code is expired, please resend Verification Code'], 400);
        }

        // update otp and otp expiry
        $user->otp = null;
        $user->otp_expiry = null;
        $user->email_verified_at = now();
        $user->save();

        // return response
        return response()->json([
            'message' => 'Email verified successfully',
            'user' => $user->load('roles')
        ], 200);
    }

    // change email
    public function changeEmail(Request $request)
    {
        // dd($request->all());
        // validate old email and new email
        // $request->validate([
        //     'new_email' => 'required|email',
        // ]);

        $user = Auth::user();

        // check if auth user email is same with new email
        if ($user->email == $request->new_email) {
            return response()->json(['message' => 'New email cannot be the same as old email'], 400);
        }

        // check if new email is already exist in database
        $checkEmail = User::where('email', $request->new_email)->first();
        if ($checkEmail) {
            return response()->json(['message' => 'New email already exist in our system'], 400);
        }

        // generate otp 5 digit alphabet and number
        $otp = strtoupper(Str::random(5));

        // save otp to database
        $user->otp = $otp;
        $user->otp_expiry = now()->addDays(3);
        $user->save();
        // jika hari ini sudah melebihi 3 hari, maka hapus otp dan otp expiry
        if ($user->otp_expiry < now()) {
            $user->otp = null;
            $user->otp_expiry = null;
        }

        // update new email
        $user->email = $request->new_email;
        $user->email_verified_at = null;

        // send otp to user
        Mail::to($user->email)->send(new EmailVerification($user, $otp));

        if ($user->save()) {
            return response()->json(['message' => 'New email have been saved, please check your email to verify your new email!'], 200);
        } else {
            return response()->json(['message' => 'Unable to save new email and send OTP'], 400);
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

    public function forgotPasswordOld(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Reset password link sent to your email'], 200)
            : response()->json(['message' => 'Unable to send reset password link'], 400);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // generate otp 5 digit alphabet and number
        $otp = strtoupper(Str::random(5));

        /* generate otp */
        // $otp = $this->otp->generate(5);

        // save otp to database
        $user->otp = $otp;
        $user->otp_expiry = now()->addMinutes(15);
        $user->save();

        // send otp to user
        // $this->sendOtpEmail($user, $otp);
        // dd($otp);
        Mail::to($user->email)->send(new OtpEmail($user, $otp));

        if ($user->save()) {
            return response()->json(['message' => 'OTP successfully sent to your email!'], 200);
        } else {
            return response()->json(['message' => 'Unable to send OTP'], 400);
        }
    }

    // login with otp
    public function loginWithOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->otp !== $request->otp) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }

        if ($user->otp_expiry < now()) {
            return response()->json(['message' => 'OTP expired'], 400);
        }

        // update otp and otp expiry
        $user->otp = null;
        $user->otp_expiry = null;
        $user->save();

        // create token
        Auth::login($user);

        // return response
        return response()->json([
            'message' => 'You have been successfully logged in!',
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user->load('roles')
        ], 200);
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

    // RESET PASSWORD JIKA MEMBER LUPA PASSWORD DAN SUDAH LOGIN MEMGGUNAKAN OTP
    public function resetPasswordWithOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
            'new_password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ], // password harus mengandung huruf besar, angka, dan simbol
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->otp !== $request->otp) {
            return response()->json(['error' => 'Invalid OTP or email'], 400);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
            'otp' => null,
            'otp_expiry' => null
        ]);

        Auth::login($user);

        return response()->json(['message' => 'Password reset successfully'], 200);
    }

    // edit profile for edit password
    public function editPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ],
            'new_password_confirmation' => 'required|same:new_password',
        ], [
            'new_password.regex' => 'Password must contain at least 8 characters, 1 uppercase letter, 1 digit, and 1 special character.',
        ]);

        // get user login
        $user = Auth::user();
        // dd($user);
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'Current password is incorrect'], 400);
        }

        // pengecekan password baru tidak boleh sama dengan password lama
        if (Hash::check($request->new_password, $user->password)) {
            return response()->json(['error' => 'New password cannot be the same as current password'], 400);
        }

        // pengecekan apakah password baru mengandung huruf besar, angka, dan simbol

        $user->password = Hash::make($request->new_password);
        $user->save();

        if (!$user->save()) {
            return response()->json(['error' => 'Unable to update password'], 400);
        } else {
            return response()->json(['message' => 'Password updated successfully'], 200);
        }
    }
}
