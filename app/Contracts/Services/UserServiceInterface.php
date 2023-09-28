<?php

namespace App\Contracts\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface UserServiceInterface
{
    public function registerUser(array $data): User;

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