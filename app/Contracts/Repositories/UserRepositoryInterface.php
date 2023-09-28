<?php

namespace App\Contracts\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface UserRepositoryInterface
{
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