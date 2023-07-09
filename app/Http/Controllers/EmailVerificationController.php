<?php

namespace App\Http\Controllers;

use App\Mail\VerificationEmail;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class EmailVerificationController extends Controller
{
    public function notice(): JsonResponse
    {
        return response()->json([
            'message' => 'Verification Email was sent',
        ]);
    }

    public function verify(EmailVerificationRequest $request): JsonResponse
    {
        $request->fulfill();
        $user = User::where('id', $request->id)->first();
        Auth::login($user);
        $user->save();
        return response()->json('Email has been Verified', 200);
    }

    public function changeEmail(Request $request)
    {
        /** @var \App\Models\User $user **/
        $user = Auth::user();

        $this->validate($request, [
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $newEmail = $request->email;
        $user->email = $newEmail;
        $user->email_verified_at = null;
        $user->save();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(config('auth.verification.expire', 60)),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );

        Mail::to($newEmail)->send(new VerificationEmail($verificationUrl));

        return response()->json('Email has been updated. Please check your email for verification.', 200);
    }

}
