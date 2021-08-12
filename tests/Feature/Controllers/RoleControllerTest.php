<?php

namespace Tests\Feature\Controllers;

use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Role;
use Tests\Feature\Helpers;
use Tests\TestCase;

class RoleControllerTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
        $this->seed(RoleSeeder::class);
        // now re-register all the roles and permissions (clears cache and reloads relations)
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();
    }

    /**
     * @test
     * @group
     *
     * @return void
     */
    public function should_get_user_and_app_roles()
    {
        //arrange
        $user = Helpers::getAccountUserLoggedWithAccount('show_all_role');
        $route = '/api/v1/account/role';
        $roles = Role::where([
            ['module', '=', 'invoice'],
            ['account_id', '=', null]])
            ->orWhere('account_id', $user->account->id)
            ->get();
        $responseData = Helpers::makeResponseApiMock('Consulta Realizada com sucesso!!!', 200, $roles->toArray(), $route, "GET");

        //act
        $response = $this->get($route);

        //assert
        $response->assertStatus(200);
        $response->assertJson($responseData);
    }

    /**
     * @test
     * @group
     *
     */
    public function should_sign_user_to_role()
    {
        //arrange
        $user = Helpers::getAccountUserLoggedWithAccount('sign_role');
        $employee = $user->account->employees[0];
        $role = Role::where('module', 'invoice')->first();
        $postData = ['employee_id' => $employee->id, 'role_id' => $role->id];
        $route = '/api/v1/account/role/sign';
        $responseData = Helpers::makeResponseApiMock('Permissão atribuida com Sucesso!!!', 200, $postData, $route, 'POST');

        //act
        $response = $this->post($route, $postData);

        //assert
        $response->assertStatus(200);
        $response->assertJson($responseData);
        $this->assertTrue($employee->hasRole($role->name));

    }

    /**
     * @test
     * @group
     */
    public function should_get_employe_roles()
    {
        //arrange
        $user = Helpers::getAccountUserLoggedWithAccount('show_role');
        $employee = $user->account->employees[0];
        $employee->assignRole('seller');
        $roles = $employee->roles;
        $route = '/api/v1/account/role/employee/' . $employee->id;
        $responseData = Helpers::makeResponseApiMock('Consulta Realizada Com Sucesso!!!', 200, $roles->toArray(), $route, "GET");

        //act
        $response = $this->get($route);

        //assert
        $response->assertStatus(200);
        $response->assertJson($responseData);

    }

    /**
     * @test
     * @group roles
     *
     */
    public function should_unsign_role_from_employee()
    {
        //arrange
        $user = Helpers::getAccountUserLoggedWithAccount('unsign_role');
        $employee = $user->account->employees[0];
        $employee->assignRole('seller');
        $roles = $employee->roles;

        $postData = ['employee_id' => $employee->id, 'role_id' => $roles[0]->id];
        $route = '/api/v1/account/role/unsign';
        $responseData = Helpers::makeResponseApiMock('Tipo de acesso removido com Sucesso!!!', 200, $postData, $route, "DELETE");

        //act
        $response = $this->delete($route, $postData);

        //assert
        $response->assertStatus(200);
        $response->assertJson($responseData);

    }

}
