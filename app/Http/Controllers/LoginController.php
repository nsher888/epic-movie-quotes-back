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
        $attributes = $request-> validated();

        if (!Auth::attempt($attributes)) {
            return response()->json([
                'message' => 'Invalid login details',
            ], 401 );
        }

        return response()->json([
            'message' => 'User logged in successfully',
            'user' => Auth::user(),
        ], 201);

    }

    public function logOut(Request $request)
    {
        Auth::guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([], 204);
    }
}

