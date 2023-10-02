<?php

namespace App\Contracts\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface UserRepositoryInterface
{
    public function getAll(): Collection;

    public function getPaginated(?int $page = 1, ?int $perPage = 10): LengthAwarePaginator;

    /**
     * @throws ModelNotFoundException
     */
    public function getById(int $id): User;

    /**
     * @throws ModelNotFoundException
     */
    public function getByEmail(string $email): User;

    public function create(array $data): User;

    /**
     * @throws ModelNotFoundException
     */
    public function update(int $id, array $data): User;

    /**
     * @throws ModelNotFoundException
     */
    public function delete(int $id): void;
}
