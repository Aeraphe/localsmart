<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{

    use RefreshDatabase;

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
}
