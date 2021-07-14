<?php

namespace Modules\Gadget\Tests\Unit\Entities;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Gadget\Entities\GadgetType;
use Modules\Gadget\Entities\Manufacturer;
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
        $data =  ['name' => 'IPhone 11'];

        //act
        $result = Gadget::factory()->create()



    }
}
