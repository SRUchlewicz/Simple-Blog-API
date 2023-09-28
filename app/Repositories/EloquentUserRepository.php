<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function getAll(): Collection
    {
        return User::with('role')->all();
    }

    public function getPaginated(?int $page = 1, ?int $perPage = 10): LengthAwarePaginator
    {
        return User::with('role')->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getById(int $id): User
    {
        return User::with('role')->findOrFail($id);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getByEmail(string $email): User
    {
        return User::with('role')->where('email', $email)->firstOrFail();
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