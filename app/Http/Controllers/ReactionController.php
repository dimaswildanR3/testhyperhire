<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Person;
use Illuminate\Database\QueryException;

/**
 * @OA\Tag(
 *     name="Reaction",
 *     description="API endpoints for liking/disliking people"
 * )
 */
class ReactionController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/people/{id}/like",
     *     tags={"Reaction"},
     *     summary="Like a person",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Person ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="user_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Liked successfully"),
     *     @OA\Response(response=404, description="Person not found")
     * )
     */
    public function like($id, Request $request)
    {
        $userId = $request->input('user_id'); 
        $person = Person::findOrFail($id);

        if ($userId) {
            try {
                Like::updateOrCreate(
                    ['person_id' => $person->id, 'user_id' => $userId],
                    ['is_like' => true]
                );
            } catch (QueryException $e) {
                Like::create([
                    'person_id' => $person->id,
                    'user_id' => $userId,
                    'is_like' => true,
                ]);
            }
        } else {
            Like::create([
                'person_id' => $person->id,
                'user_id' => null,
                'is_like' => true,
            ]);
        }

        return response()->json(['message' => 'liked'], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/people/{id}/dislike",
     *     tags={"Reaction"},
     *     summary="Dislike a person",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Person ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="user_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Disliked successfully"),
     *     @OA\Response(response=404, description="Person not found")
     * )
     */
    public function dislike($id, Request $request)
    {
        $userId = $request->input('user_id');
        $person = Person::findOrFail($id);

        if ($userId) {
            Like::updateOrCreate(
                ['person_id' => $person->id, 'user_id' => $userId],
                ['is_like' => false]
            );
        } else {
            Like::create([
                'person_id' => $person->id,
                'user_id' => null,
                'is_like' => false,
            ]);
        }

        return response()->json(['message' => 'disliked'], 200);
    }
}
