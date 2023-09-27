<?php

namespace App\Contracts\Http\V1;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Http\JsonResponse;

interface ResetPasswordControllerInterface
{
    /**
     * @OA\Post(
     *     path="/api/v1/forgot-password",
     *     summary="Forgot Password",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 format="email"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse;

    /**
     * @OA\Post(
     *     path="/api/v1/reset-password",
     *     summary="Reset Password",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"token", "password"},
     *             @OA\Property(
     *                 property="token",
     *                 type="string",
     *                 format="string"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 format="password"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse;
 
}