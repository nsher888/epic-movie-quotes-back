<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\EditMovieRequest;
use App\Http\Requests\Admin\StoreMovieRequest;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller
{
    public function index(): JsonResponse
    {
        $user = auth()->user();
        $movie = Movie::where('user_id', $user->id)->get();
        return response()->json([
            'movies' => $movie,
        ], 201);
    }

    public function store(StoreMovieRequest $request): JsonResponse
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
        $file = $request->file('image');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/images', $filename);
        $movie->image = url('storage/images/' . $filename);

        $movie->save();

        return response()->json('success', 201);
    }

    public function show($id): JsonResponse
    {
        $movie = Movie::find($id);
        return response()->json([
            'movie' => $movie,
        ], 201);
    }

    public function destroy($id): JsonResponse
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json('Movie not found', 404);
        }

        if ($movie->user_id !== auth()->user()->id) {
            return response()->json('Unauthorized', 401);
        }

        $movie->delete();

        return response()->json('Movie deleted successfully', 200);
    }

    public function update(EditMovieRequest $request, $id): JsonResponse
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json('Movie not found', 404);
        }

        if ($movie->user_id !== auth()->user()->id) {
            return response()->json('Unauthorized', 401);
        }

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
        $file = $request->file('image');

        if ($file) {
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images', $filename);
            $movie->image = url('storage/images/' . $filename);
        }

        $movie->save();

        return response()->json('Movie updated successfully', 200);
    }
}
