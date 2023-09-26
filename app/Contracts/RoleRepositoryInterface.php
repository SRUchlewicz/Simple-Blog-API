<?php

namespace App\Contracts;

interface RoleRepositoryInterface
{
    public function findByName(string $name);

    public function getDefaultRoleId(): int;
}
