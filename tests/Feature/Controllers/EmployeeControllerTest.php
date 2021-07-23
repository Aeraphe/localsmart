<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * @test
     *
     * @return void
     */
    public function it_create_a_employee()
    {
        //arrange
        $account = Account::factory()->create();
        $user = $account->user;
        $postData = [

            'name' => 'Ricardo',
            'phone' => $this->faker->name,
            'address' => $this->faker->address,
            'email' => $this->faker->email,
            'login_name' => 'ricardo',
            'password' => hash('sha256', 'password'),
        ];

        Passport::actingAs($user);

        //act
        $response = $this->post('api/v1/account/employee', $postData);
   

        //assert
        $response->assertStatus(200);
        $this->assertDatabaseHas('employees',$postData);

    }
}
