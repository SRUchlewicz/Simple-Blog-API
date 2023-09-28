<?php

namespace App\Repositories;

use App\Contracts\Repositories\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentPostRepository implements PostRepositoryInterface
{
    public function getAll(): Collection
    {
        return Post::with('media')->get();
    }

    public function getPaginated(?int $page = 1, ?int $perPage = 10): LengthAwarePaginator
    {
        return Post::with('media')->paginate($perPage, ['*'], 'page', $page);
    }
    
    /**
     * @throws ModelNotFoundException
     */
    public function getById($id): Post
    {
        return Post::with('media')->findOrFail($id);
    }

    public function create($data): Post
    {
        return Post::create($data);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function update($id, $data): Post
    {
        $post = $this->getById($id);
        $post->update($data);
        return $post;
    }

    /**
     * @throws ModelNotFoundException
     */
    public function delete($id): void
    {
        $post = $this->getById($id);
        $post->delete();
    }
}