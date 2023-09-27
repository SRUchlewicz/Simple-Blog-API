<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\ApiController;
use App\Contracts\Http\V1\ResetPasswordControllerInterface;
use App\Contracts\Services\ResetPasswordServiceInterface;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Http\JsonResponse;
use Exception;


class ResetPasswordController extends ApiController implements ResetPasswordControllerInterface
{
    private $resetPasswordService;

    public function __construct(
        ResetPasswordServiceInterface $resetPasswordService
    ) {
        $this->resetPasswordService = $resetPasswordService;
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            $this->resetPasswordService->sendResetToken($request->validated()['email']);
            return response()->json(['message' => 'Reset token sent']);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $this->resetPasswordService->resetPassword($data['token'], $data['password']);
            return response()->json(['message' => 'Password reset successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }

    public function verifyToken(ResetPasswordRequest $request)
    {
        $token = $request->input('token');
        try {
            $decoded = JWTAuth::setToken($token)->getPayload();
        } catch (\Exception $e) {
            // Token invalid or expired
            return response()->json(['error' => 'Invalid token.']);
        }

        $email = $decoded['email'];
        $action = $decoded['action'];
        $exp = $decoded['exp'];

        if ($action !== 'password_reset') {
            return response()->json(['error' => 'Invalid action.']);
        }

        if ($exp < time()) {
            return response()->json(['error' => 'Token expired.']);
        }

        // Proceed with password reset for $email
    }
}
