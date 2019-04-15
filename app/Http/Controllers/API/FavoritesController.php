<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MovieResource;
use App\Movie;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::paginate(15);
        return MovieResource::collection($movies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->get('id');
        try {
            $data = Tmdb::getMoviesApi()->getMovie($id);
            $attributes = [
                'movie_id' => $data['id'],
                'title' => $data['title'],
                'overview' => $data['overview'],
                'vote_average' => $data['vote_average'],
                'user_id' => auth()->id(),
            ];
            $movie = Movie::create($attributes);
            return new MovieResource($movie);
        }
        catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 406);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        return new MovieResource($movie);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();
        return new MovieResource($movie);
    }
}
