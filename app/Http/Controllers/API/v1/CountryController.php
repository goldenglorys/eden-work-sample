<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Models\CountriesOfDomicile;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CountryController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/v1/countries",
     * summary="Display all Countries of Domicile",
     * description="Get all countries",
     * operationId="countries",
     * tags={"countries"},
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *     ),
     * )
     */
    public function index()
    {
        try {
            $countries = CountriesOfDomicile::all();
            return response()->json([
                'success' => true,
                'data' => $countries,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     * path="/api/v1/countries/{countryId}",
     * summary="Country of domicile by id",
     * description="Get country by id",
     * operationId="countriesById",
     * tags={"countries"},
     * @OA\Parameter(
     *    description="ID of country",
     *    in="path",
     *    name="countryId",
     *    required=true,
     *    example="1",
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *     ),
     * @OA\Response(
     *    response=404,
     *    description="Country with given ID not found",
     *     ),
     * )
     */
    public function show($id)
    {
        try {
            $country = CountriesOfDomicile::findorFail($id);
            return response()->json([
                'success' => true,
                'data' => $country,
            ], 200);
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'success' => true,
                    'error' => 'Data not found.'
                ], Response::HTTP_NOT_FOUND);
            }
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
