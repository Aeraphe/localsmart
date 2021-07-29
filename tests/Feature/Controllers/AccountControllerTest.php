<?php

namespace Tests\Feature\Controllers;

use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\Feature\Helpers;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{

    use RefreshDatabase;

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
     * @group account
     *
     * @return void
     */
    public function should_register_new_account()
    {

        //arrange
        $postData = [
            'name' => 'Alberto ',
            'email' => "test@test.com",
            'password' => 'password',
            'password_confirmation' => "password",

        ];

        $responseStructure = [
            'data',
            '_message',
            '_status',
            '_url',
            '_method',
        ];

        //act
        $response = $this->post('api/v1/account/register', $postData);

        //assert
        $response->assertStatus(200);
        $response->assertJsonFragment(["_message" => "Conta criada com sucesso"], $response->getContent());
        $response->assertJsonStructure($responseStructure, $response->getContent());

    }

    /**
     * @test
     * @group account
     */
    public function it_fail_if_email_already_exists_on_database()
    {

        //arrange
        $postData = [
            'name' => 'Alberto ',
            'email' => "test@test.com",
            'password' => 'password',
            'password_confirmation' => "password",

        ];

        $responseStructure = [
            'data',
            '_message',
            '_status',
            '_url',
            '_method',
        ];

        $this->post('api/v1/account/register', $postData);

        //act
        $response = $this->post('api/v1/account/register', $postData);

        //assert
        $response->assertStatus(302);

    }

    /**
     * @test
     * @group account
     */
    public function should_edit_account()
    {
        //arrange
        $user = Helpers::getAccountUserLoggedWithAccount('edit_account');
        $postData = ['slug' => 'LocalSmart'];
        $route = '/api/v1/account';
        $dataResponse = Helpers::makeResponseApiMock('Dados alterados com sucesso!!!', 200, $postData, $route, 'PUT');
        //act
        $response = $this->put($route, $postData);

        //assert
        $response->assertStatus(200);
        $this->assertDatabaseHas('accounts', ['id' => $user->account->id, 'slug' => 'LocalSmart']);
        $response->assertJson($dataResponse);
    }

    /**
     * @test
     * @group account
     */
    public function should_show_account()
    {
        //arrange
        $user = Helpers::getAccountUserLoggedWithAccount('show_account');
        $account = $user->account->with('stores', 'employees')->first();
        $route = '/api/v1/account';
        $dataResponse = Helpers::makeResponseApiMock('Consulta Realizada co  sucesso!!!', 200, $account->toArray(), $route, 'GET');
        //act
 
        $response = $this->get($route);
 
        //assert
        $response->assertStatus(200);
        $response->assertJson($dataResponse);
    }

}
