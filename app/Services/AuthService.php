<?php

namespace App\Services;

use App\Contracts\Services\AuthServiceInterface;
use App\Contracts\Services\TokenServiceInterface;
use App\Contracts\Services\RoleServiceInterface;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Validation\ValidationException;
use App\Exceptions\InsufficientPermissionsException;

class AuthService implements AuthServiceInterface
{
    private $tokenService;
    private $roleService;

    public function __construct(
        TokenServiceInterface $tokenService,
        RoleServiceInterface $roleService
    ) {
        $this->tokenService = $tokenService;
        $this->roleService = $roleService;
    }

    /**
     * @throws ValidationException
     * @throws JWTException
     * @throws InsufficientPermissionsException
     */
    public function login(array $credentials): string
    {
        if (! $token = $this->tokenService->createAuthToken($credentials)) {
            throw ValidationException::withMessages([
                'credentials' => ['These credentials do not match our records.'],
            ]);
        }

        if (!$this->isUserAllowedToLogin($token)) {
            throw new InsufficientPermissionsException("This user is not allowed to login");
        }
    
        return $token;
    }

    /**
     * @throws JWTException
     */
    public function logout(): void
    {
        $this->tokenService->invalidate();
    }

    private function isUserAllowedToLogin($token): bool
    {
        $roleName = $this->tokenService->getRoleNameFromToken($token);
        
        if (!in_array($roleName, $this->roleService->getNamesOfAllowedRolesToLogin())) {
            return false;
        }

        return true;
    }
}
