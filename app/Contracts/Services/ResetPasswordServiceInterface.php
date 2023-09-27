<?php

namespace App\Contracts\Services;

interface ResetPasswordServiceInterface
{
    public function sendResetToken(string $email): void;

    public function resetPassword(string $token, string $newPass): void;
}