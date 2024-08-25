<?php
namespace App\Service;
use App\Models\Movie;
use Illuminate\Support\Facades\Log;

class MovieService{
public function createMovie(array $data){

return Movie ::create($data);

}
/**
 * Summary of updateMovie
 * @param \App\Models\Movie $movie
 * @param mixed $data
 * @return Movie
 */
public function updateMovie(Movie $movie, $data)
    {
        $movie->update(array_filter($data));
        return $movie;
    }
    /**
     * Summary of deleteMovie
     * @param \App\Models\Movie $movie
     * @return Movie
     */
    public function deleteMovie(Movie $movie)
   {
    Log::info("Attempting to delete movie with ID: {$movie}");
         $movie->delete();
         return $movie;
        //  Log::info("Attempting to delete movie with ID: {$movie}");
    }

}