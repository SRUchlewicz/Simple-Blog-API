<?php

namespace App\Contracts\Repositories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface RoleRepositoryInterface
{
    /**
     * @throws ModelNotFoundException
     */
    public function getByName(string $name): Role;

    /**
     * @throws ModelNotFoundException
     */
    public function getDefaultRoleId(): int;
}
