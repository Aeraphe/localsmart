<?php

namespace Tests\Feature\PermissionFactory;

use Database\Seeders\Permissions\EmployeePermissionFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class EmployeePermissionFactoryTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     * @group permissions
     * @return void
     */
    public function can_create_employee_permissions()
    {
        //arrange

        Role::create(['guard_name' => 'web', 'name' => 'admin']);
        Role::create(['guard_name' => 'web', 'name' => 'seller']);
        Role::create(['guard_name' => 'web', 'name' => 'repair']);

        Role::create(['guard_name' => 'api', 'name' => 'admin']);
        Role::create(['guard_name' => 'api', 'name' => 'seller']);
        Role::create(['guard_name' => 'api', 'name' => 'repair']);

        Role::create(['guard_name' => 'employee', 'name' => 'admin']);
        Role::create(['guard_name' => 'employee', 'name' => 'seller']);
        Role::create(['guard_name' => 'employee', 'name' => 'repair']);

        //act
        EmployeePermissionFactory::create();

        //assert
        $this->assertDatabaseHas('permissions', ['name' => 'create_employee']);

    }
}
