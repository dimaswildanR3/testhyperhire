<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;

/**
 * @OA\Tag(
 *     name="Liked",
 *     description="API endpoints for liked people"
 * )
 */
class LikedController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/liked",
     *     tags={"Liked"},
     *     summary="Get list of liked people",
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="List of liked people")
     * )
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $userId = $request->query('user_id');

        $query = Like::where('is_like', true)->with('person.pictures');

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $result = $query->paginate($perPage);

        return response()->json($result);
    }
}
