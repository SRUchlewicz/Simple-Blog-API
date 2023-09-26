<?php

namespace App\Contracts\Http\V1;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface AuthControllerInterface
{
    /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     summary="Log in a user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Login")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Logged in successfully"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function login(Request $request): JsonResponse;
 
    /**
     * @OA\Post(
     *     path="/api/v1/logout",
     *     summary="Logs out the current user",
     *     tags={"Authentication"},
     *     security={{"Bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logged out successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Logged out successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="could_not_invalidate_token"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="could_not_invalidate_token"
     *             )
     *         )
     *     )
     * )
     */
    public function logout(): JsonResponse;

}