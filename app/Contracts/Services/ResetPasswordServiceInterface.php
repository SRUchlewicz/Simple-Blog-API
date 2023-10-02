<?php

namespace App\Contracts\Services;

use App\Exceptions\InvalidTokenException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface ResetPasswordServiceInterface
{
    /**
     * @throws ModelNotFoundException
     */
    public function sendResetToken(string $email): void;

    /**
     * @throws InvalidTokenException
     * @throws ModelNotFoundException
     */
    public function resetPassword(string $token, string $newPass): void;
}
