<?php

namespace App\Contracts\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface PostRepositoryInterface
{
    public function getAll(): Collection;

    public function getPaginated(?int $page = 1, ?int $perPage = 10): LengthAwarePaginator;

    /**
     * @throws ModelNotFoundException
     */
    public function getById($id): Post;

    public function create($data): Post;
    
    /**
     * @throws ModelNotFoundException
     */
    public function update($id, $data): Post;

    /**
     * @throws ModelNotFoundException
     */
    public function delete($id): void;
}