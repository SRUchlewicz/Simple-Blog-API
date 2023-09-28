<?php

namespace App\Contracts\Services;

use App\Models\User;

interface UserServiceInterface
{
    public function register(array $data): User;

    /**
     * @throws UserNotFoundException
     */
    public function update(int $id, array $data): ?User;

    /**
     * @throws UserNotFoundException
     */
    public function delete(int $id): void;

    /**
     * @throws UserNotFoundException
     */
    public function changeUserPassword(string $email, string $newPass): void;
}