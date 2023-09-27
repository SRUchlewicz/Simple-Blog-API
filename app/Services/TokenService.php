<?php

namespace App\Services;

use App\Contracts\Services\TokenServiceInterface;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\RevokedToken;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Contracts\Repositories\UserRepositoryInterface;

class TokenService implements TokenServiceInterface
{
    private $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws JWTException
     */
    public function invalidate(): void
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        //$this->revokeTokenInDb(); //TODO implement revoke logic
    }

    private function revokeTokenInDb(): void
    {
        $userId = auth()->user()->id;
        $jti = JWTAuth::getPayload(JWTAuth::getToken())['jti'];
        RevokedToken::create(['user_id' => $userId, 'jti' => $jti]);
    }

    public function generateResetPasswordToken(string $email): string
    {
        $user = $this->userRepository->findByEmail($email);
        $customClaims = ['email' => $email, 'action' => 'password_reset', 'exp' => strtotime('+1 hour')];
        return JWTAuth::customClaims($customClaims)->fromUser($user);
    }
    
    public function validateToken(string $token)
    {
        //$token = $request->input('token');
        try {
            $userId = auth()->user()->id;
            $decoded = JWTAuth::setToken($token)->getPayload();
            $jti = $decoded['jti'];
            // Check if the token is in the revoked_tokens table
            if (RevokedToken::where('jti', $jti)->where('user_id', $userId)->exists()) {
                return response()->json(['error' => 'Token has been revoked.']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid token.']);
        }
    }

    public function validateResetPasswordToken(string $token): bool
    {
        try {
            $decoded = JWTAuth::setToken($token)->getPayload();
        } catch (\Exception $e) {
            // Token invalid or expired
            return false;
            return response()->json(['error' => 'Invalid token.']);
        }

        $email = $decoded['email'];
        $action = $decoded['action'];
        $exp = $decoded['exp'];

        if ($action !== 'password_reset') {
            return false;
            return response()->json(['error' => 'Invalid action.']);
        }

        if ($exp < time()) {
            return false;
            return response()->json(['error' => 'Token expired.']);
        }

        return true;
    }

    public function getEmailFromToken(string $token): ?string
    {
        try {
            $decoded = JWTAuth::setToken($token)->getPayload();
        } catch (\Exception $e) {
            // Token invalid or expired
            return false;
            return response()->json(['error' => 'Invalid token.']);
        }

        return $decoded['email'] ?? null;
    }

    /**
     * @throws JWTException
     */
    public function create(array $credentials): ?string
    {
        return JWTAuth::attempt($credentials);
    }
}