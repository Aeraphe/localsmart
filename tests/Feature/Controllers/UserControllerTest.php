<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\Feature\Helpers;
use Tests\TestCase;

class UserControllerTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
        $this->seed();
        // now re-register all the roles and permissions (clears cache and reloads relations)
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();
    }

    /**
     * @test
     * @group user
     *
     * @return void
     */
    public function should_show_user()
    {
        //arrange
        $user = Helpers::getAccountUserLoggedWithAccount('show_user');
        $route = '/api/v1/account/user/' . $user->id;
        $data = $user->toArray();
        unset($data['permissions']);
        $responseData = Helpers::makeResponseApiMock('Consulta Realizada com sucesso!!!', '200', $data, $route, 'GET');
        //act
        $response = $this->get($route);

        //assert
        $response->assertStatus(200);
        $response->assertJson($responseData);
    }
}
