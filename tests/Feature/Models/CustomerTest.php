<?php

namespace Tests\Feature\Models;

use App\Models\Account;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    /**
     * @test
     *
     * @return void
     */
    public function can_create_a_customer_for_the_user_account()
    {
        //arrange
        $account = Account::factory()->create();
        $customerData = [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'cpf' => $this->faker->randomLetter,
            'account_id' => $account->id,
            'phone' => $this->faker->phoneNumber,
            'city' => $this->faker->city,
            'state' => $this->faker->country,
            'obs' => $this->faker->text,
        ];
        //act
        $sut = Customer::create($customerData);

        //assert
        $this->assertInstanceOf(Customer::class,$sut);
        $this->assertDatabaseHas('customers',$customerData);

    }
}
