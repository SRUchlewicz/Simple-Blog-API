<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\ApiController;
use App\Contracts\Http\V1\ResetPasswordControllerInterface;
use App\Contracts\Services\ResetPasswordServiceInterface;
use App\Contracts\Services\TokenServiceInterface;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Http\JsonResponse;
use Exception;
use App\Exceptions\InvalidTokenException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class ResetPasswordController extends ApiController implements ResetPasswordControllerInterface
{
    private $resetPasswordService;
    private $tokenService;

    public function __construct(
        ResetPasswordServiceInterface $resetPasswordService,
        TokenServiceInterface $tokenService
    ) {
        $this->resetPasswordService = $resetPasswordService;
        $this->tokenService = $tokenService;
    }

    /**
     * {@inheritdoc}
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            $this->resetPasswordService->sendResetToken($request->validated()['email']);
            return response()->json(['message' => 'Reset token sent'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'User with such email not found'], 404);
        } catch (Exception $e) {
            Log::error('An error occured during forgot password: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $this->resetPasswordService->resetPassword($data['token'], $data['password']);
            $this->tokenService->invalidate($data['token']);
            return response()->json(['message' => 'Password reset successfully'], 200);
        } catch (InvalidTokenException $e) {
            return response()->json(['message' => 'Invalid Token', 'error' => $e->getMessage()], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'User with such email not found'], 404);
        } catch (Exception $e) {
            Log::error('An error occured during password reset: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }
}
