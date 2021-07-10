<?php

namespace Tests\Feature\Models;

use App\Models\Account;
use App\Models\Customer;
use App\Models\Equipament;
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
        $this->assertInstanceOf(Customer::class, $sut);
        $this->assertDatabaseHas('customers', $customerData);

    }

    /**
     * Test relationship Customer to Account
     * @test
     */
    public function should_get_account_that_customer_belongs()
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
        $sut = Customer::create($customerData);

        //act
        $result = $sut->account;

        //assert
        $this->assertInstanceOf(Account::class, $result);
    }

    /**
     * @test
     *
     * @return void
     */
    public function can_get_cutomer_equipaments()
    {
        //arrange
        $sut = Customer::factory()->create();
        $equipaments = Equipament::factory()->count(2)->create(['customer_id' => $sut->id]);

        //act
        $result = $sut->equipaments;

        //assert
        $this->assertTrue($result->contains($equipaments[0]));
    }
}
