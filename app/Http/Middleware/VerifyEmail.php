<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class VerifyEmail extends Middleware
{
    protected function redirectTo($request): string
    {
        if (!$request->expectsJson()) {
            $user = User::find($request->id);
            if ($user->email_verified_at === null) {
                $user->markEmailAsVerified();
                $user->save();
                return env('APP_FRONT_URL') . '/'  . '?verify=true';
            } else {
                return env('APP_FRONT_URL') . '/'  . '/403';
            }
        }
    }
}
