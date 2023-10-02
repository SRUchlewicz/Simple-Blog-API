<?php

namespace App\Contracts\Services;

interface RoleServiceInterface
{
    public function getNamesOfAllowedRolesToLogin(): array;
}
