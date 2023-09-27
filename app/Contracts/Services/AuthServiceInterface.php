<?php

namespace App\Contracts\Services;

use Illuminate\Validation\ValidationException;

interface AuthServiceInterface
{
    /**
     * @throws ValidationException
     * @throws JWTException
     */
    public function login(array $credentials): string;
  
    /**
     * @throws JWTException
     */
    public function logout(): void;

}