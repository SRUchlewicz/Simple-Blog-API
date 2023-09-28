<?php

namespace App\Contracts\Services;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface PostServiceInterface
{
    public function getAllPosts(): Collection;

    public function getPostsByPage(?int $page = 1): LengthAwarePaginator;

    /**
     * @throws ModelNotFoundException
     */
    public function getPostById(int $id): Post;

    public function createPost(array $data): Post;

    /**
     * @throws ModelNotFoundException
     */
    public function updatePost(int $id, array $data): Post;

    /**
     * @throws ModelNotFoundException
     */
    public function deletePost(int $id): void;
}