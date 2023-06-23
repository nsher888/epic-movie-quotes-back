<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    public function store()
    {
        $attributes = request()->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        $user = User::create($attributes);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ], 201);

    }
}
