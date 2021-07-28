<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\Feature\Helpers;
use Tests\TestCase;

class StoreControllerTest extends TestCase
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
     * @group store
     *
     * @return void
     */
    public function should_show_store()
    {
        //arrange
        $user = Helpers::getAccountUserLoggedWithAccount('show_all_store');
        $route = '/api/v1/store';
        $storeResponseData = $user->account->stores->toArray();
        $responseData = Helpers::makeResponseApiMock('Consulta realizada com sucesso', 200, $storeResponseData, $route, "GET");

        //act
        $response = $this->get($route);

        //assert
        $response->assertStatus(200);
        $response->assertJson($responseData);
    }
}
