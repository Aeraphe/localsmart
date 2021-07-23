<?php

namespace Tests\Feature\Services;

use App\Models\Account;
use App\Models\Customer;
use App\Models\User;
use App\Services\RegisterCustomerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class RegisterCustomerServiceTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * @test
     *
     * @return void
     */
    public function can_create_a_customer()
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
        $resp = RegisterCustomerService::create($data);

        //assert
        $this->assertDatabaseHas('customers', $data);
        $this->assertInstanceOf(Customer::class, $resp);

    }
}
