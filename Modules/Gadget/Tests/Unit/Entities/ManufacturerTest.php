<?php

namespace Modules\Gadget\Tests\Unit\Entities;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Gadget\Entities\Manufacturer as EntitiesManufacturer;
use Tests\TestCase;

class ManufacturerTest extends TestCase
{

    use WithFaker, RefreshDatabase;
    /**
     * @test
     *
     * @return void
     */
    public function can_create_gadget_manufactorer()
    {
        //arrange
        $data = ['name' => 'Apple'];

        //act
        $result = EntitiesManufacturer::factory()->create($data);

        //assert
        $this->assertInstanceOf(EntitiesManufacturer::class, $result);
        $this->assertDatabaseHas('manufacturers', $data);

    }
}
