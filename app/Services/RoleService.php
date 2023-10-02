<?php

namespace App\Services;

use App\Contracts\Services\RoleServiceInterface;
use App\Contracts\Repositories\RoleRepositoryInterface;

class RoleService implements RoleServiceInterface
{
    public const ALLOWED_ROLES_FOR_LOGIN_CONFIG_KEY = 'custom.allowed_roles_for_login';

    private $roleRepository;

    public function __construct(
        RoleRepositoryInterface $roleRepository
    ) {
        $this->roleRepository = $roleRepository;
    }

    public function getNamesOfAllowedRolesToLogin(): array
    {
        return config(self::ALLOWED_ROLES_FOR_LOGIN_CONFIG_KEY);
    }
}
