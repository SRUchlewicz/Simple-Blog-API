<?php

namespace App\Contracts;

use App\Models\User;
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