<?php

namespace Tests\Feature\Models;

use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    private function getStoreData()
    {
        return [
            'name' => 'LocalSmart',
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
        ];
    }

    /**
     * @test
     *
     * @return void
     */
    public function can_create_a_store()
    {
        //arrange
        $storeData = $this->getStoreData();

        //act
        $sut = Store::factory()->create($storeData);

        //assert
        $this->assertInstanceOf(Store::class, $sut);
        $this->assertDatabaseHas('stores', $storeData);
    }
}
