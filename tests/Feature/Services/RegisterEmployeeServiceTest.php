<?php

namespace Tests\Feature\Services;

use App\Models\Account;
use App\Models\Employee;
use App\Services\RegisterEmployeeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;
use Tests\TestCase;

class RegisterEmployeeServiceTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function should_create_an_employee()
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
            'password' => Hash::make('password'),
        ];
        Passport::actingAs($user);

        //act
        $response = RegisterEmployeeService::create($postData);

        //aseert
        $this->assertInstanceOf(Employee::class, $response);

    }

}
