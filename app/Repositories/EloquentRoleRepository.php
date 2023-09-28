<?php

namespace App\Repositories;

use App\Contracts\Repositories\RoleRepositoryInterface;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentRoleRepository implements RoleRepositoryInterface
{
    /**
     * @throws ModelNotFoundException
     */
    public function getByName(string $name): Role
    {
        return Role::where('name', $name)->firstOrFail();
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getDefaultRoleId(): int
    {
        return Role::where('name', Role::DEFAULT_ROLE)->firstOrFail()->id;
    }

    public function getByNames(array $names): Collection
    {
        return Role::whereIn('name', $names)->get();
    }
}
