<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EditMovieRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title_en'             => 'required',
            'title_ka'             => 'required',
            'director_en'          => 'required',
            'director_ka'          => 'required',
            'description_en'       => 'required',
            'description_ka'       => 'required',
            'genre'                => 'optional',
            'year'                 => 'required',
            'image'                => 'nullable',
        ];
    }
}
