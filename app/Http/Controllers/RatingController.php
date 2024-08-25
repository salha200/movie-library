<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Service\RatingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    protected $ratingService;
    
    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    /**
     * Retrieve a paginated list of ratings
     *@param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ratings = Rating::with('movie')->paginate(5);

        return response()->json([
            'data' => $ratings->items(),
            'per_page' => $ratings->perPage(),]);
    }

    /**
     * Store a newly created rating in database
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'movie_id' => 'required|exists:movies,id',
            'rating' => 'required|integer|between:1,5',
            'review' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $rating = $this->ratingService->createRating($request->all());
            return response()->json($rating, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display  rating.
     *
     * @param Rating $rating
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show(Rating $rating)
    {
        return response()->json($rating->load('movie'));
    }

    /**
     * Update the rating in database.
     *
     * @param \Illuminate\Http\Request $request
     * @param Rating $rating
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Rating $rating)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|between:1,5',
            'review' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $updatedRating = $this->ratingService->updateRating($rating, $request->all());
            return response()->json($updatedRating);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified rating from storage.
     *
     * @param \App\Models\Rating $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rating $rating)
    {
        try {
            $this->ratingService->deleteRating($rating);
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
