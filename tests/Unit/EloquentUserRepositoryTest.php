<?php

namespace Tests\Unit;

use App\Repositories\EloquentUserRepository;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\RolesTableSeeder;

class EloquentUserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new EloquentUserRepository();
        $this->artisan('db:seed', ['--class' => RolesTableSeeder::class]);
    }

    /** @test */
    public function itCanGetUserById()
    {
        $user = User::factory()->create();

        $found = $this->repository->getById($user->id);

        $this->assertInstanceOf(User::class, $found);
        $this->assertEquals($user->id, $found->id);
    }

    /** @test */
    public function itCanCreateUser()
    {
        $data = [
            'firstname' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'role_id' => 1
        ];

        $user = $this->repository->create($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($data['firstname'], $user->firstname);
        $this->assertEquals($data['email'], $user->email);
    }

    /** @test */
    public function itCanUpdateUser()
    {
        $user = User::factory()->create();

        $data = ['firstname' => 'Jane Doe'];

        $updatedUser = $this->repository->update($user->id, $data);

        $this->assertInstanceOf(User::class, $updatedUser);
        $this->assertEquals($data['firstname'], $updatedUser->firstname);
    }

    /** @test */
    public function itCanDeleteUser()
    {
        $user = User::factory()->create();

        $this->repository->delete($user->id);

        $this->assertNull(User::find($user->id));
    }
}
