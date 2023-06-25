<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function LogIn(LoginRequest $request)
    {
        $attributes = $request->validated();
        $loginInput = $attributes['email'];

        $user = User::where('email', $loginInput)
                    ->orWhere('name', $loginInput)
                    ->first();

        if (!$user || !Auth::attempt(['email' => $user->email, 'password' => $attributes['password']])) {
            return response()->json([
                'message' => 'Invalid login details',
            ], 401);
        }

        return response()->json([
            'message' => 'User logged in successfully',
            'user' => Auth::user(),
        ], 201);
    }

    public function logOut(Request $request)
    {
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged Out' ], 204);
    }
}

