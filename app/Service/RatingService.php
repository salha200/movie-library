<?php

namespace App\Service;

use App\Models\Rating;

class RatingService
{
    /**
     * Create a new rating.
     *
     * @param array $data
     * @return \App\Models\Rating
     */
    public function createRating(array $data)
    {
        return Rating::create($data);
    }

    /**
     * Update an existing rating.
     *
     * @param Rating $rating
     * @param array $data
     * @return \App\Models\Rating
     */
    public function updateRating(Rating $rating, array $data)
    {
        $rating->update($data);
        return $rating;
    }

    /**
     * Delete a rating.
     *
     * @param Rating $rating
     * @return void
     */
    public function deleteRating(Rating $rating)
    {
        $rating->delete();
    }
}
