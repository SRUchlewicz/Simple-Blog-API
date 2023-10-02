<?php

namespace App\Contracts\Http\V1;

use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\JsonResponse;

interface RegistrationControllerInterface
{
    /**
     * @OA\Post(
     *     path="/api/v1/register",
     *     summary="Register a new user",
     *     tags={"Account"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RegisterUser")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="User registered successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="An error occurred"
     *             )
     *         )
     *     )
     * )
     */
    public function register(RegisterUserRequest $request): JsonResponse;
}
