<?php

namespace Modules\Gadget\Tests\Unit\Entities;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Gadget\Entities\GadgetType;
use Tests\TestCase;

class GadgetTypeTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * @test
     *
     * @return void
     */
    public function should_create_gadget_type()
    {
        //arrange
        $data = ['name' => 'celular'];

        //act
        $result = GadgetType::factory()->create($data);

        //assert
        $this->assertInstanceOf(GadgetType::class, $result);
        $this->assertDatabaseHas('gadget_types', $data);
    }
}
