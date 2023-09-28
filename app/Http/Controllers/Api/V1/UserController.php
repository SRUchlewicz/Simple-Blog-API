<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\ApiController;
use App\Contracts\Http\V1\UserControllerInterface;
use App\Contracts\Services\UserServiceInterface;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends ApiController implements UserControllerInterface
{
    private $userService;

    public function __construct(
        UserServiceInterface $userService
    ) {
        $this->userService = $userService;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $users = $this->userService->getUsersByPage($request->get('page'));
            return response()->json(['users' => $users], 200);
        } catch (Exception $e) {
            Log::error('An error occurred during getting users: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $this->userService->createUser($request->validated());
            return response()->json(['message' => 'User created successfully'], 201);
        } catch (Exception $e) {
            Log::error('An error occurred during user creation: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }

    public function edit(int $id): JsonResponse
    {
        try {
            $user = $this->userService->getUserById($id);
            return response()->json(['user' => $user], 200);
        } catch(ModelNotFoundException $e) {
            return response()->json(['message' => 'User not found'], 404);
        } catch (Exception $e) {
            Log::error('An error occurred during getting user: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }

    public function update($id, UpdateUserRequest $request): JsonResponse
    {
        try {
            $post = $this->userService->updateUser($id, $request->validated());
            return response()->json(['message' => 'User updated successfully'], 200);
        } catch(ModelNotFoundException $e) {
            return response()->json(['message' => 'User not found'], 404);
        } catch (Exception $e) {
            Log::error('An error occurred during user update: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $post = $this->userService->deleteUser($id);
            return response()->json(['message' => 'User deleted successfully'], 200);
        } catch(ModelNotFoundException $e) {
            return response()->json(['message' => 'User not found'], 404);
        } catch (Exception $e) {
            Log::error('An error occurred during user delete: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }
}
