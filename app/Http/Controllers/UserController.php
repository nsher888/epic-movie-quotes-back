<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function updateName(Request $request): JsonResponse
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->name = $request->input('name');
        $user->save();

        return response()->json(['message' => 'User name updated successfully']);
    }

    public function changePassword(Request $request): JsonResponse
    {
        $request->validate([
            'password' => 'required|min:8|max:15|regex:/^[a-z0-9]+$/',
            'confirm_password' => 'required|same:password',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Password changed successfully']);
    }

    public function uploadAvatar(Request $request): JsonResponse
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $file = $request->file('avatar');

        $filename = uniqid() . '.' . $file->getClientOriginalExtension();

        $file->storeAs('public/images/avatars', $filename);

        $user = auth()->user();
        $user->avatar = url('storage/images/avatars/' . $filename);
        $user->save();

        return response()->json(['message' => 'Avatar uploaded successfully']);
    }
}
