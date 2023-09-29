<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\ApiController;
use App\Contracts\Http\V1\PostAdminControllerInterface;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\JsonResponse;
use App\Contracts\Services\PostServiceInterface;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Events\PostCreated;
use App\Events\PostUpdated;

class PostAdminController extends ApiController implements PostAdminControllerInterface
{
    private $postService;

    public function __construct(
        PostServiceInterface $postService
    ) {
        $this->postService = $postService;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $posts = $this->postService->getPostsByPage($request->get('page'));
            return response()->json(['posts' => $posts], 200);
        } catch (Exception $e) {
            Log::error('An error occurred during getting posts: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }

    public function store(StorePostRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['user_id'] = $request->user()->id;
            $post = $this->postService->createPost($data);
            event(new PostCreated($post));
            return response()->json(['message' => 'Post created successfully'], 201);
        } catch (Exception $e) {
            Log::error('An error occurred during post creation: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }

    public function edit(int $id): JsonResponse
    {
        try {
            $post = $this->postService->getPostById($id);
            return response()->json(['post' => $post], 200);
        } catch(ModelNotFoundException $e) {
            return response()->json(['message' => 'Post not found'], 404);
        } catch (Exception $e) {
            Log::error('An error occurred during getting post: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }

    public function update($id, UpdatePostRequest $request): JsonResponse
    {
        try {
            $post = $this->postService->updatePost($id, $request->validated());
            event(new PostUpdated($post));
            return response()->json(['message' => 'Post updated successfully'], 200);
        } catch(ModelNotFoundException $e) {
            return response()->json(['message' => 'Post not found'], 404);
        } catch (Exception $e) {
            Log::error('An error occurred during post update: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->postService->deletePost($id);
            return response()->json(['message' => 'Post deleted successfully'], 200);
        } catch(ModelNotFoundException $e) {
            return response()->json(['message' => 'Post not found'], 404);
        } catch (Exception $e) {
            Log::error('An error occurred during post delete: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }
}
