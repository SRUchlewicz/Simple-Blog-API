<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\ApiController;
use App\Contracts\Http\V1\RegistrationControllerInterface;
use App\Contracts\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class RegistrationController extends ApiController implements RegistrationControllerInterface
{
    protected $userService;

    public function __construct(
        UserServiceInterface $userService
    ) {
        $this->userService = $userService;
    }

    /**
     * {@inheritdoc}
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $this->userService->register($request->all());
            return response()->json(['message' => 'User registered successfully'], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
        
    }
}
