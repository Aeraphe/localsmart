<?php

namespace Tests\Feature\Models;

use App\Models\Customer;
use App\Models\Equipament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EquipamentTest extends TestCase
{

    use RefreshDatabase, WithFaker;
    /**
     * @test
     *
     * @return void
     */
    public function should_create_equipament()
    {

        //arrange and act
        $result = Equipament::factory()->create();

        //assert
        $this->assertInstanceOf(Equipament::class, $result);
        $this->assertDatabaseHas('equipaments', ['id' => $result->id]);

    }

    /**
     * @test
     *
     * @return void
     */
    public function can_get_equipament_owner()
    {
        //arrange
        $customer = Customer::factory()->create();
        $sut = Equipament::factory()->create(['customer_id' => $customer->id]);

        //act
        $result = $sut->customer;

        //assert
        $this->assertInstanceOf(Customer::class, $result);
        $this->assertEquals($customer->id, $result->id);
    }
}
