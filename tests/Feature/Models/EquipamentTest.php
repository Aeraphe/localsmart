<?php

namespace Tests\Feature\Models;

use App\Models\Equipament;
use Tests\TestCase;

class EquipamentTest extends TestCase
{
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
}
