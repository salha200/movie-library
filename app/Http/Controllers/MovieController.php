<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Service\MovieService;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    protected $movieService;
    /**
     * constractor to inject MovieService  class
     * @param \App\Service\MovieService $movieService
     */
    public function __construct(MovieService $movieService)
    {
        //injecting the MovieService to controller
        $this->movieService = $movieService;
    }
    /**
     * Retrieve a paginated list of movies with optional filtering, sorting, and pagination.
     * @param  Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
{
    // Retrieve the field by which the movies should be sorted, defaulting to 'release_year' if not provided.

    $sortField = $request->input('sort_by', 'release_year');
    // Retrieve the sort direction 
    $sortDirection = $request->input('sort_order', 'asc'); 
//if statment for ort direction is either 'asc' or 'desc
    if (!in_array($sortDirection, ['asc', 'desc'])) {
        return response()->json(['error' => 'Invalid sort order'], 400);
    }

  //quary
    $query = Movie::query();
//if statment for filter 'genre'
   
    if ($request->has('genre')) {
        $query->where('genre', $request->input('genre'));
    }
//if statment for filter 'director'
    if ($request->has('director')) {
        $query->where('director', $request->input('director'));
    }

    //
    $query->orderBy($sortField, $sortDirection);

   //paginate the movie in page
    $movies = $query->paginate(10);

    return response()->json([
        'data' => $movies->items(), 
        'per_page' => $movies->perPage(),
        'total' => $movies->total(), 
    ]);}
    /**
     * Store the newly movie in database
     * @param Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
             'title' => 'required|string|max:255',
            'director' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'release_year' => 'required|integer',
            'description' => 'nullable|string',
        ]);
//Use movieService summon from him the createMovie
        $movie = $this->movieService->createMovie($data);

        return response()->json($movie, 201);
    }
/**
 * upate the movie already exist
 * @param Request $request
 * @param Movie $movie
 * @return mixed|\Illuminate\Http\JsonResponse
 */
  
    public function update(Request $request, Movie $movie)
    {
        $data = $request->validate([
            'title' => 'string|max:255',
            'director' => 'string|max:255',
            'genre' => 'string|max:255',
            'release_year' => 'required|integer',
            'description' => 'nullable|string',
           
        ]);

        $updatedMovie = $this->movieService->updateMovie($movie, $data);

        return response()->json($updatedMovie, 200);
    }

    /**
     * destroy movie from database
     * @param Movie $movie
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(Movie $movie)
    {
     
         $this->movieService->deleteMovie($movie);

   
    return response()->json(['sucess' => 'Movie delet'], 200);
    
}
}