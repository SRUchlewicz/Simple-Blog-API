<?php

namespace App\Services;

use App\Contracts\Services\TokenServiceInterface;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use App\Exceptions\InvalidTokenException;
use App\Contracts\Repositories\UserRepositoryInterface;
use Tymon\JWTAuth\Payload;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TokenService implements TokenServiceInterface
{
    public const RESET_PASSWORD_TOKEN_ACTION_KEY = 'password_reset';
    public const RESET_PASSWORD_TOKEN_TTL_CONFIG_KEY = 'custom.reset_password_token_ttl';

    private $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws JWTException
     */
    public function createAuthToken(array $credentials): ?string
    {
        return JWTAuth::attempt($credentials);
    }

    /**
     * @throws JWTException
     */
    public function invalidate(?string $token = null): void
    {
        if (!$token) {
            $token = JWTAuth::getToken();
        }

        JWTAuth::invalidate(JWTAuth::getToken());
        //$this->revokeTokenInDb(); // TODO implement revoke logic
    }

    /**
     * @throws ModelNotFoundException
     */
    public function createResetPasswordToken(string $email): string
    {
        $user = $this->userRepository->getByEmail($email);
        $customClaims = [
            'email' => $email,
            'action' => self::RESET_PASSWORD_TOKEN_ACTION_KEY,
            'exp' => now()->addMinutes($this->getResetPasswordTokenTTL())->timestamp
        ];

        return JWTAuth::customClaims($customClaims)->fromUser($user);
    }

    /**
     * @throws InvalidTokenException
     */
    public function validateResetPasswordToken(string $token): void
    {
        try {
            $tokenData = $this->getDataFromToken($token);
        } catch (TokenExpiredException $e) {
            throw new InvalidTokenException("The reset password token has expired");
        } catch (JWTException $e) {
            throw new InvalidTokenException("The reset password token is invalid");
        }

        if ($tokenData['action'] !== self::RESET_PASSWORD_TOKEN_ACTION_KEY) {
            throw new InvalidTokenException("The token is invalid for reset password");
        }
    }
    
    /**
     * @throws InvalidTokenException
     */
    public function getEmailFromToken(string $token): string
    {
        try {
            $tokenData = $this->getDataFromToken($token);
        } catch (JWTException $e) {
            throw new InvalidTokenException("The token is invalid");
        }

        if (!isset($tokenData['email'])) {
            throw new InvalidTokenException("The token does not have email data");
        }

        return $tokenData['email'];
    }

    /**
     * @throws InvalidTokenException
     */
    public function getRoleNameFromToken(string $token): string
    {
        try {
            $tokenData = $this->getDataFromToken($token);
        } catch (JWTException $e) {
            throw new InvalidTokenException("The token is invalid");
        }

        if (!isset($tokenData['role'])) {
            throw new InvalidTokenException("The token does not have role data");
        }

        return $tokenData['role'];
    }

    /**
     * @throws JWTException
     */
    private function getDataFromToken(string $token): Payload
    {
        return JWTAuth::setToken($token)->getPayload();
    }

    private function getResetPasswordTokenTTL(): int
    {
        return (int) config(self::RESET_PASSWORD_TOKEN_TTL_CONFIG_KEY);
    }

    private function revokeTokenInDb(): void
    {
        // TODO implement revoke logic
    }
}
