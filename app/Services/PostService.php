<?php

namespace App\Services;

use App\Contracts\Services\PostServiceInterface;
use App\Contracts\Repositories\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostService implements PostServiceInterface
{
    private $postRepository;

    public function __construct(
        PostRepositoryInterface $postRepository
    ) {
        $this->postRepository = $postRepository;
    }

    public function getAllPosts(): Collection
    {
        return $this->postRepository->getAll();
    }

    public function getPostsByPage(?int $page = 1): LengthAwarePaginator
    {
        return $this->postRepository->getPaginated($page, getDefaultPerPage());
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getPostById(int $id): Post
    {
        return $this->postRepository->getById($id);
    }

    public function createPost(array $data): Post
    {
        return DB::transaction(function () use ($data) {
            $post = $this->postRepository->create([
                'title' => $data['title'],
                'body' => $data['body'],
                'user_id' => $data['user_id'],
            ]);

            if (isset($data['media_ids'])) {
                $post->media()->sync($data['media_ids']);
            }

            return $post;
        });
    }

    /**
     * @throws ModelNotFoundException
     */
    public function updatePost(int $id, array $data): Post
    {
        return DB::transaction(function () use ($id, $data) {
            $post = $this->postRepository->update(
                $id, 
                [
                    'title' => $data['title'],
                    'body' => $data['body']
                ]
            );

            if (isset($data['media_ids'])) {
                $post->media()->sync($data['media_ids']);
            }

            return $post;
        });
    }

    /**
     * @throws ModelNotFoundException
     */
    public function deletePost(int $id): void
    {
        $this->postRepository->delete($id);
    }
}