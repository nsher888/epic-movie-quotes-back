<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request): JsonResponse
    {
        $attributes = $request->validated();

        $user = User::create($attributes);

        event(new Registered($user));

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ], 201);

    }
}
