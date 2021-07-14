<?php

namespace Modules\Gadget\Tests\Unit;

use Modules\Gadget\Entities\Repair;
use Tests\TestCase;

class RepairTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function should_create_gadget_repair()
    {
        //arrange
        $data = [
            'name' => 'Troca do Conector de carga',
            'operation' => 'solda',
            'description' => 'Retirar o display com cuidado para não quebrar',
            'dificult' => 3,
        ];

        //act
        $result = Repair::factory()->create($data);

        //assert
        $this->assertDatabaseHas('repairs', $data);
        $this->assertInstanceOf(Repair::class, $result);
    }
}
