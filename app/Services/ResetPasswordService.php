<?php

namespace App\Services;

use App\Contracts\Services\ResetPasswordServiceInterface;
use App\Contracts\Services\TokenServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use App\Exceptions\InvalidTokenException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ResetPasswordService implements ResetPasswordServiceInterface
{
    private $tokenService;
    private $userService;

    public function __construct(
        TokenServiceInterface $tokenService,
        UserServiceInterface $userService
    ) {
        $this->tokenService = $tokenService;
        $this->userService = $userService;
    }

    /**
     * @throws ModelNotFoundException
     */
    public function sendResetToken(string $email): void
    {
        Mail::to($email)->send(
            new ResetPasswordMail($this->tokenService->createResetPasswordToken($email))
        );
    }

    /**
     * @throws InvalidTokenException
     * @throws ModelNotFoundException
     */
    public function resetPassword(string $token, string $newPass): void
    {
        $this->tokenService->validateResetPasswordToken($token);
        $this->userService->changeUserPassword(
            $this->tokenService->getEmailFromToken($token),
            $newPass
        );
    }
}
