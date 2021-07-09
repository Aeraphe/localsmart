<?php

namespace Tests\Feature\Models;

use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreTest extends TestCase
{

    use WithFaker, RefreshDatabase;


    private function getStoreData($userId){
        return [
            'name' => 'LocalSmart',
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'user_id' => $userId,
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
        $user = User::factory()->create();
        $storeData = $this->getStoreData($user->id);

        //act
        $sut = Store::create($storeData);

        //assert
        $this->assertDatabaseHas('stores', $storeData);
    }
}
