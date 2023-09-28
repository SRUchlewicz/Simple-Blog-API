<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentUserRepository implements UserRepositoryInterface
{
    /**
     * @throws ModelNotFoundException
     */
    public function getById(int $id): User
    {
        return User::findOrFail($id);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getByEmail(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function update(int $id, array $data): User
    {
        $user = $this->getById($id);
        $user->update($data);
        return $user;
    }

    /**
     * @throws ModelNotFoundException
     */
    public function delete(int $id): void
    {
        $user = $this->getById($id);
        $user->delete();
    }
}