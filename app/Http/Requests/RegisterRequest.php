<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:15|regex:/^[a-z0-9]+$/',
            'email' => 'required|email',
            'password' => 'required|min:8|max:15|regex:/^[a-z0-9]+$/',
            'confirm_password' => 'required|same:password',
        ];
    }
}
