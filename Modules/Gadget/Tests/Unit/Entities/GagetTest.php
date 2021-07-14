<?php

namespace Modules\Gadget\Tests\Unit\Entities;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Gadget\Entities\Gadget;
use Tests\TestCase;

class GagetTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /**
     * @test
     *
     * @return void
     */
    public function can_create_gadget()
    {
        //arrange
        $data = ['name' => 'iPhone 11'];

        //act
        $result = Gadget::factory()->create($data);

        //assert
        $this->assertInstanceOf(Gadget::class, $result);
        $this->assertDatabaseHas('gadgets', $data);

    }
}
