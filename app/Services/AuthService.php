<?php

namespace App\Services;

use App\Contracts\Services\AuthServiceInterface;
use App\Contracts\Services\TokenServiceInterface;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthServiceInterface
{
    private $tokenService;

    public function __construct(
        TokenServiceInterface $tokenService
    ) {
        $this->tokenService = $tokenService;
    }

    /**
     * {@inheritdoc}
     *
     * @throws ValidationException
     * @throws JWTException
     */
    public function login(array $credentials): string
    {
        if (! $token = $this->tokenService->create($credentials)) {
            throw ValidationException::withMessages([
                'credentials' => ['These credentials do not match our records.'],
            ]);
        }
    
        return $token;
    }

    /**
     * {@inheritdoc}
     *
     * @throws JWTException
     */
    public function logout(): void
    {
        $this->tokenService->invalidate();
    }
}
