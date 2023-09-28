<?php

namespace App\Contracts\Services;

interface ResetPasswordServiceInterface
{
    public function sendResetToken(string $email): void;

    /**
     * @throws InvalidTokenException
     */
    public function resetPassword(string $token, string $newPass): void;
}