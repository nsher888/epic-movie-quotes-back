<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreMovieRequest;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $movie = Movie::where('user_id', $user->id)->get();
        return response()->json([
            'movies' => $movie,
        ], 201);
    }

    public function store(StoreMovieRequest $request)
    {
        $movie = new Movie();
        $movie->title = [
            'en' => $request->input('title_en'),
            'ka' => $request->input('title_ka'),
        ];
        $movie->director = [
            'en' => $request->input('director_en'),
            'ka' => $request->input('director_ka'),
        ];
        $movie->description = [
            'en' => $request->input('description_en'),
            'ka' => $request->input('description_ka'),
        ];
        $movie->year = $request->input('year');
        $movie->user_id = auth()->user()->id;

        $movie->save();

        return response()->json('success', 201);
    }


}
