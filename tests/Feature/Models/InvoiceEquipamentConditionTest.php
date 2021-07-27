<?php

namespace Tests\Feature\Models;

use App\Models\Equipament;
use App\Models\InvoiceEquipamentCondition;
use App\Models\RepairInvoice;
use Tests\TestCase;

class InvoiceEquipamentConditionTest extends TestCase
{
    /**
     * @test
     * group equipament
     * @return void
     */
    public function can_create_invoice_equipament_condition()
    {
        //arrange

        $invoice = RepairInvoice::factory()->has(Equipament::factory()->count(1))->create();
        $data = [
            'name' => 'Without test condition',
            'repair_invoice_id' => $invoice->id,
            'equipament_id' => $invoice->equipament->id,
        ];

        //act
        $result = InvoiceEquipamentCondition::factory()->create($data);

        //assert
        $this->assertDatabaseHas('invoice_equipament_conditions', $data);
        $this->assertInstanceOf(InvoiceEquipamentCondition::class, $result);

    }
}
