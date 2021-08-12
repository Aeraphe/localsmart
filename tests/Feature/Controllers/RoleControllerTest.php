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
     * @group roles
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
}
