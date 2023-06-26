<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function callback(): Response
    {
        $user = Socialite::driver('google')->stateless()->user();

        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::where('email', $googleUser->getEmail())->first();
        if (!$user) {
            $saveUser = User::create([
                'name'      => $googleUser->getName(),
                'email'     => $googleUser->getEmail(),
                'thumbnail' => $googleUser->getAvatar(),
                'google_id' => $googleUser->getId(),
                'provider'  => 'google',
            ]);

            auth()->login($saveUser);
            if (auth()->check()) {
                return response('', 200);
            } else {
                return response()->json('Login failed');
            }
        } else {
            auth()->login($user);
            return response('', 200);
        }
    }
}
