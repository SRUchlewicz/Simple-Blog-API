<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\ApiController;
use App\Contracts\Http\V1\AuthControllerInterface;
use App\Contracts\Services\AuthServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Exceptions\InsufficientPermissionsException;
use Illuminate\Support\Facades\Log;
use App\Events\UserLoggedIn;
use App\Events\UserLoggedOut;

class AuthController extends ApiController implements AuthControllerInterface
{
    private $authService;

    public function __construct(
        AuthServiceInterface $authService
    ) {
        $this->authService = $authService;
    }

    /**
     * {@inheritdoc}
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $token = $this->authService->login($request->all());
            event(new UserLoggedIn(auth()->user()));
            return response()->json(['token' => $token], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        } catch (InsufficientPermissionsException $e) {
            return response()->json(['message' => 'You do not have sufficient permissions'], 403);
        } catch (JWTException $e) {
            Log::error('An error occured during login: ' . $e->getMessage());
            return response()->json(['message' => 'Could not create token'], 500);
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function logout(): JsonResponse
    {
        try {
            $user = auth()->user();
            $this->authService->logout();
            event(new UserLoggedOut($user));
            return response()->json(['message' => 'Logged out successfully'], 200);
        } catch (JWTException $e) {
            Log::error('An error occured during logout: ' . $e->getMessage());
            return response()->json(['message' => 'Could not invalidate token'], 500);
        }
    }
}
