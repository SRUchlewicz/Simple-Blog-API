<?php

namespace App\Repositories;

use App\Contracts\Repositories\RoleRepositoryInterface;
use App\Models\Role;

class EloquentRoleRepository implements RoleRepositoryInterface
{
    public function findByName(string $name)
    {
        return Role::where('name', $name)->first();
    }

    public function getDefaultRoleId(): int
    {
        return Role::where('name', Role::DEFAULT_ROLE)->first()->id;
    }
}
