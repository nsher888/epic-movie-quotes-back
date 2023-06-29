<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'password' => 'required|min:8|max:15|regex:/^[a-z0-9]+$/',
            'confirm_password' => 'required|same:password',
            'token' => 'required',
        ];
    }
}
