<?php

namespace Tests\Unit\Services;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Exceptions\InvalidTokenException;
use App\Services\TokenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Payload;

//use Tymon\JWTAuth\JWTAuth;

class TokenServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $tokenService;
    protected $userRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepository = Mockery::mock(UserRepositoryInterface::class);
        $this->tokenService = new TokenService($this->userRepository);
    }

    /**
     * @test
     */
    public function itCreatesAnAuthToken()
    {
        $credentials = ['email' => 'email@example.com', 'password' => 'password'];
        JWTAuth::shouldReceive('attempt')->with($credentials)->andReturn('tokenString');

        $token = $this->tokenService->createAuthToken($credentials);

        $this->assertEquals('tokenString', $token);
    }

    /**
     * @test
     */
    public function itThrowsExceptionForInvalidResetPasswordToken()
    {
        $this->expectException(InvalidTokenException::class);

        $mockPayload = Mockery::mock(Payload::class);
        $mockPayload->shouldReceive('offsetExists')->with('action')->andReturn(true);
        $mockPayload->shouldReceive('offsetGet')->with('action')->andReturn('someOtherAction');

        JWTAuth::shouldReceive('setToken')->andReturnSelf();
        JWTAuth::shouldReceive('getPayload')->andReturn($mockPayload);

        $this->tokenService->validateResetPasswordToken('invalidResetToken');
    }

    /**
     * @test
     */
    public function itThrowsExceptionWhenEmailIsMissingFromToken()
    {
        $this->expectException(InvalidTokenException::class);

        $mockPayload = Mockery::mock(Payload::class);
        $mockPayload->shouldReceive('offsetExists')->with('email')->andReturn(false);
    
        JWTAuth::shouldReceive('setToken')->andReturnSelf();
        JWTAuth::shouldReceive('getPayload')->andReturn($mockPayload);
    
        $this->tokenService->getEmailFromToken('invalidToken');
    }

    /**
     * @test
     */
    public function itThrowsExceptionWhenRoleIsMissingFromToken()
    {
        $this->expectException(InvalidTokenException::class);

        $mockPayload = Mockery::mock(Payload::class);
        $mockPayload->shouldReceive('offsetExists')->with('role')->andReturn(false);
    
        JWTAuth::shouldReceive('setToken')->andReturnSelf();
        JWTAuth::shouldReceive('getPayload')->andReturn($mockPayload);
    
        $this->tokenService->getRoleNameFromToken('invalidToken');
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
