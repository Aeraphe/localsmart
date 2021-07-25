<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
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
     *
     * @return void
     */
    public function should_create_customer()
    {

        //arrange
        $user = Account::factory()->create()->user;
        Passport::actingAs($user);
        $data = [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'cpf' => $this->faker->randomLetter,
            'rg' => $this->faker->randomLetter,
            'phone' => $this->faker->phoneNumber,
            'city' => $this->faker->city,
            'state' => $this->faker->country,
            'district' => $this->faker->address,
            'obs' => $this->faker->text,
        ];

        //act
        $result = $this->post('api/v1/account/customer', $data);

        //assert
        $result->assertStatus(200);
        $this->assertDatabaseHas('customers', $data);
        $result->assertJsonFragment([
            '_message' => 'Cliente Cadastrado com sucesso',
            'data' => ['name' => $data['name']],
        ]);

    }

 
}
