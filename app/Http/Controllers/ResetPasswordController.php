<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetRequest;
use App\Http\Requests\storeEmailRequest;
use App\Http\Requests\storeResetPasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function sendResetLink(storeEmailRequest $request): JsonResponse
    {
        app()->setLocale($request->local);
        $request->validated();
        $status = Password::sendResetLink(
            $request->only('email'),
        );

        return $status === Password::RESET_LINK_SENT
        ? response()->json('Password reset link sent!', 200)
         : response()->json('email not found', 404);
    }

    public function showResetForm($token): JsonResponse
    {
        return response()->json(['token' => $token, 'email' => request()->email]);
    }

    public function resetPassword(ResetRequest $request): JsonResponse
    {
        $request->validated();
        $status = Password::reset(
            $request->only('email', 'password', 'confirm_password', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );
        return $status === Password::PASSWORD_RESET
                    ? response()->json('Password has changed successfully!', 200)
                    : response()->json(['email' => [__($status)]], 404);
    }
}
