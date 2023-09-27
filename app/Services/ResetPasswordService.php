<?php

namespace App\Services;

use App\Contracts\Services\ResetPasswordServiceInterface;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use App\Contracts\Services\TokenServiceInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;
use App\Contracts\Services\UserServiceInterface;

class ResetPasswordService implements ResetPasswordServiceInterface
{
    private $tokenService;

    private $userRepository;

    private $userService;

    public function __construct(
        TokenServiceInterface $tokenService,
        UserRepositoryInterface $userRepository,
        UserServiceInterface $userService
    ) {
        $this->tokenService = $tokenService;
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function sendResetToken(string $email): void
    {
        Log::info('send reset');
        //$user = $this->userRepository->findByEmail($email);
        Mail::to($email)->send(new ResetPasswordMail($this->tokenService->generateResetPasswordToken($email)));
        Log::info('after send');
        //Mail::queue(new ResetPasswordMail($this->tokenService->create()))->onQueue('emails');
    }

    public function resetPassword(string $token, string $newPass): void
    {
        if ($this->tokenService->validateResetPasswordToken($token)) {
            $this->userService->changeUserPassword($this->tokenService->getEmailFromToken($token), $newPass);
        }
    }
}