<?php

namespace Tests\Feature\Models;

use App\Models\RepairInvoice;
use App\Models\RepairInvoiceStatus;
use Tests\TestCase;

class RepairInvoiceStatusTest extends TestCase
{
    /**
     * A @test
     *
     * @return void
     */
    public function can_create_a_repair_invoice_status()
    {
        //arrange
        $invoice = RepairInvoice::factory()->create();
        $data = [
            'repair_invoice_id' => $invoice->id,
            'description' => 'Open',
            'status' => 1,
        ];

        //act
        $result = RepairInvoiceStatus::factory()->create($data);

        //assert
        $this->assertDatabaseHas('repair_invoice_statuses', $data);
        $this->assertInstanceOf(RepairInvoiceStatus::class, $result);
    }
}
