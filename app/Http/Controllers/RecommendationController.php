<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;

/**
 * @OA\Tag(
 *     name="People",
 *     description="API endpoints for People"
 * )
 */

/**
 * @OA\Schema(
 *     schema="Person",
 *     type="object",
 *     title="Person",
 *     required={"id","name"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="age", type="integer", example=25),
 *     @OA\Property(property="latitude", type="number", format="float", example=-6.200000),
 *     @OA\Property(property="longitude", type="number", format="float", example=106.816666),
 *     @OA\Property(
 *         property="pictures",
 *         type="array",
 *         @OA\Items(type="string", example="https://example.com/picture.jpg")
 *     )
 * )
 */
class RecommendationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/recommendations",
     *     tags={"People"},
     *     summary="Get list of recommended people",
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of items per page",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Parameter(
     *         name="lat",
     *         in="query",
     *         description="Latitude for location filter",
     *         required=false,
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Parameter(
     *         name="lng",
     *         in="query",
     *         description="Longitude for location filter",
     *         required=false,
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Parameter(
     *         name="radius_km",
     *         in="query",
     *         description="Radius in km for location filter",
     *         required=false,
     *         @OA\Schema(type="number", format="float", default=50)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of recommended people",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Person")
     *             ),
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(property="last_page", type="integer"),
     *             @OA\Property(property="per_page", type="integer"),
     *             @OA\Property(property="total", type="integer")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);

        $query = Person::with(['pictures']);

        if ($request->has(['lat','lng','radius_km'])) {
            $lat = (float) $request->query('lat');
            $lng = (float) $request->query('lng');
            $radius = (float) $request->query('radius_km', 50);
            $deg = $radius / 111; 
            $query->whereBetween('latitude', [$lat - $deg, $lat + $deg])
                  ->whereBetween('longitude', [$lng - $deg, $lng + $deg]);
        }

        $people = $query->paginate($perPage);

        return response()->json($people);
    }

    /**
     * @OA\Get(
     *     path="/api/people/{id}",
     *     tags={"People"},
     *     summary="Get a single person",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Person ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Person object",
     *         @OA\JsonContent(ref="#/components/schemas/Person")
     *     ),
     *     @OA\Response(response=404, description="Person not found")
     * )
     */
    public function show($id)
    {
        $person = Person::with('pictures')->findOrFail($id);
        return response()->json($person);
    }
}
