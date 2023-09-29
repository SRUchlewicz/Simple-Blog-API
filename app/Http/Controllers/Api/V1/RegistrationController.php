<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\ApiController;
use App\Contracts\Http\V1\RegistrationControllerInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Events\UserRegistered;

class RegistrationController extends ApiController implements RegistrationControllerInterface
{
    private $userService;

    public function __construct(
        UserServiceInterface $userService
    ) {
        $this->userService = $userService;
    }

    /**
     * {@inheritdoc}
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->createUser($request->validated());
            event(new UserRegistered($user));
            return response()->json(['message' => 'User registered successfully'], 201);
        } catch (Exception $e) {
            Log::error('An error occurred during registration: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }
}
