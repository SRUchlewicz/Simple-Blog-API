<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\ApiController;
use App\Contracts\Http\V1\PostControllerInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Post;
use App\Contracts\Services\PostServiceInterface;
use Exception;
use Illuminate\Support\Facades\Log;

class PostController extends ApiController implements PostControllerInterface
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

    public function show($id)
    {
        return Post::with('media')->find($id);
    }
}
