<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\ApiController;
use App\Contracts\Http\V1\RegistrationControllerInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\JsonResponse;
use Exception;

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
            $this->userService->register($request->validated());
            return response()->json(['message' => 'User registered successfully'], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }
}
