<?php

namespace Tests\Unit\Services;

use App\Services\UserService;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Repositories\RoleRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private $userRepository;
    private $roleRepository;
    private $userService;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = Mockery::mock(UserRepositoryInterface::class);
        $this->roleRepository = Mockery::mock(RoleRepositoryInterface::class);

        $this->userService = new UserService($this->userRepository, $this->roleRepository);
    }

    /**
     * @test
     */
    public function itGetsAllUsers()
    {
        $this->userRepository->shouldReceive('getAll')->andReturn(new Collection());
        $result = $this->userService->getAllUsers();

        $this->assertInstanceOf(Collection::class, $result);
    }

    /**
     * @test
     */
    public function itGetsUsersByPage()
    {
        $this->userRepository->shouldReceive('getPaginated')->andReturn(new LengthAwarePaginator([], 0, 1));
        $result = $this->userService->getUsersByPage();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }

    /**
     * @test
     */
    public function itGetsUserById()
    {
        $this->userRepository->shouldReceive('getById')->andReturn(new User());
        $result = $this->userService->getUserById(1);

        $this->assertInstanceOf(User::class, $result);
    }

    /**
     * @test
     */
    public function itCreatesUser()
    {
        $this->userRepository->shouldReceive('create')->andReturn(new User());
        $this->roleRepository->shouldReceive('getDefaultRoleId')->andReturn(1);

        $data = ['firstname' => 'John', 'email' => 'john@example.com', 'password' => 'password'];
        $result = $this->userService->createUser($data);

        $this->assertInstanceOf(User::class, $result);
    }

    /**
     * @test
     */
    public function itUpdatesUser()
    {
        $this->userRepository->shouldReceive('update')->andReturn(new User());

        $data = ['firstname' => 'John', 'email' => 'john@example.com', 'password' => 'password'];
        $result = $this->userService->updateUser(1, $data);

        $this->assertInstanceOf(User::class, $result);
    }

    /**
     * @test
     */
    public function itDeletesUser()
    {
        $this->userRepository->shouldReceive('delete')->andReturnNull();
        $this->userService->deleteUser(1);
        $this->addToAssertionCount(1);
    }

    /**
     * @test
     */
    public function itChangesUserPassword()
    {
        $user = new User();
        $user->id = 1;

        $this->userRepository->shouldReceive('getByEmail')->andReturn($user);
        $this->userRepository->shouldReceive('update')->andReturn(new User());
        
        $this->userService->changeUserPassword('john@example.com', 'newpassword');
        $this->addToAssertionCount(1);
    }
}
