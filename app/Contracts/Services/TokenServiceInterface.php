<?php

namespace App\Contracts\Services;

use Tymon\JWTAuth\Exceptions\JWTException;
use App\Exceptions\InvalidTokenException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface TokenServiceInterface
{
    /**
     * @throws JWTException
     */
    public function createAuthToken(array $credentials): ?string;

    /**
     * @throws JWTException
     */
    public function invalidate(?string $token = null): void;

    /**
     * @throws ModelNotFoundException
     */
    public function createResetPasswordToken(string $email): string;

    /**
     * @throws InvalidTokenException
     */
    public function validateResetPasswordToken(string $token): void;

    /**
     * @throws InvalidTokenException
     */
    public function getEmailFromToken(string $token): string;

    /**
     * @throws InvalidTokenException
     */
    public function getRoleNameFromToken(string $token): string;
}
