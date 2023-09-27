<?php

namespace App\Contracts\Repositories;

interface RoleRepositoryInterface
{
    public function findByName(string $name);

    public function getDefaultRoleId(): int;
}
