<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tmdb\Laravel\Facades\Tmdb;

class MoviesController extends Controller
{
    public function index(Request $request) {
        if ($request->has('query')) {
            $query = $request->get('query');
            try {
                return Tmdb::getSearchApi()->searchMovies($query);
            }
            catch (\Exception $ex) {
                return response()->json(['error' => $ex->getMessage()], 406);
            }
        }
        return Tmdb::getMoviesApi()->getPopular();
    }

    public function show(Request $request, $id) {
        try {
            return Tmdb::getMoviesApi()->getMovie($id);
        }
        catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 406);
        }
    }
}
