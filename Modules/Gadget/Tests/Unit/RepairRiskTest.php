<?php

namespace Modules\Gadget\Tests\Unit;

use Modules\Gadget\Entities\RepairRisk;
use Tests\TestCase;

class RepairRiskTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function can_create_reapir_risk()
    {
        //arrange
        $data = [
            'name' => 'Quebra do display',
            'description' => '',
            'dificult' => 3,
        ];

        //act
        $result = RepairRisk::factory()->create($data);

        //assert
        $this->assertInstanceOf(RepairRisk::class, $result);
        $this->assertDatabaseHas('repair_risks', $data);
    }
}
