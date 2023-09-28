<?php

namespace App\Contracts\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface UserServiceInterface
{
    public function getAllUsers(): Collection;

    public function getUsersByPage(?int $page = 1): LengthAwarePaginator;

    /**
     * @throws ModelNotFoundException
     */
    public function getUserById(int $id): User;

    public function createUser(array $data): User;

    /**
     * @throws ModelNotFoundException
     */
    public function updateUser(int $id, array $data): ?User;

    /**
    * @throws ModelNotFoundException
    */
    public function deleteUser(int $id): void;

    /**
     * @throws ModelNotFoundException
     */
    public function changeUserPassword(string $email, string $newPass): void;
}