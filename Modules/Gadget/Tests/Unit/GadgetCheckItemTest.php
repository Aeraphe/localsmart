<?php

namespace Modules\Gadget\Tests\Unit;

use Modules\Gadget\Entities\GadgetCheckItem;
use Tests\TestCase;

class GadgetCheckItemTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function can_create_gadget_ckeck_item()
    {
        //arrange
        $data = [
            'name' => 'Verificar o TouchId',
            'risk' => 'Informar o cliente que este acessório pode estragar na abertura do display',
            'procedure' => '',
            'level' => 'h',
        ];

        //act
        $result = GadgetCheckItem::factory()->create($data);

        //assert
        $this->assertInstanceOf(GadgetCheckItem::class, $result);
        $this->assertDatabaseHas('gadget_check_items', $data);

    }
}
