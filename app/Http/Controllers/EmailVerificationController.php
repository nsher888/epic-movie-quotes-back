<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
