<?php

namespace App\Services;

use App\Contracts\AuthServiceInterface;
use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthServiceInterface
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * {@inheritdoc}
     *
     * @throws ValidationException
     * @throws JWTException
     */
    public function login(array $credentials): string
    {
        if (! $token = JWTAuth::attempt($credentials)) {
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
        JWTAuth::invalidate(JWTAuth::getToken());
    }
}
