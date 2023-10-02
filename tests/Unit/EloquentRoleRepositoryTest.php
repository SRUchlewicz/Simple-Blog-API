<?php

namespace Tests\Unit;

use App\Repositories\EloquentRoleRepository;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\RolesTableSeeder;

class EloquentRoleRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new EloquentRoleRepository();
        $this->artisan('db:seed', ['--class' => RolesTableSeeder::class]);
    }

    /** @test */
    public function itCanFindRoleByName()
    {
        $found = $this->repository->getByName('user');
        
        $this->assertInstanceOf(Role::class, $found);
        $this->assertEquals('user', $found->name);
    }

    /** @test */
    public function itCanGetDefaultRoleId()
    {
        $defaultRoleId = $this->repository->getDefaultRoleId();
        $expectedDefaultRoleId = Role::where('name', Role::DEFAULT_ROLE)->first()->id;

        $this->assertEquals($expectedDefaultRoleId, $defaultRoleId);
    }
}
