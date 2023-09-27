<?php

namespace App\Contracts\Services;

use App\Models\User;

interface UserServiceInterface
{
    public function register(array $data): User;

    public function update(int $id, array $data): ?User;

    public function delete(int $id): void;
}