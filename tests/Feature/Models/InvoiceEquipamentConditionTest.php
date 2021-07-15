<?php

namespace Tests\Feature\Models;

use App\Models\InvoiceEquipamentCondition;
use App\Models\RepairInvoice;
use Tests\TestCase;

class InvoiceEquipamentConditionTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function can_create_invoice_equipament_condition()
    {
        //arrange
        $invoice = RepairInvoice::factory()->create();
        $data = ['name' => 'Without test condition', 'repair_invoice_id' => $invoice->id];

        //act
        $result = InvoiceEquipamentCondition::factory()->create($data);

        //assert
        $this->assertDatabaseHas('invoice_equipament_conditions', $data);
        $this->assertInstanceOf(InvoiceEquipamentCondition::class, $result);

    }
}
