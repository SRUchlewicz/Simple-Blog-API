<?php

namespace App\Contracts\Services;

interface TokenServiceInterface
{
    /**
     * @throws JWTException
     */
    public function create(array $credentials): ?string;

    /**
     * @throws JWTException
     */
    public function invalidate(): void;
}