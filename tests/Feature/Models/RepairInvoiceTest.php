<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Equipament;
use App\Models\RepairInvoice;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RepairInvoiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Get invoice data fixture
     *
     * @return array
     */
    private function getInvoiceData()
    {
        $store = Store::factory()->create(); //Where the user will make the device repair
        $customer = Customer::factory()->has(Equipament::factory()->count(1), 'equipaments')->create(['account_id' => $store->account_id]);
        $equipaments = $customer->equipaments;
        return [
            'store_id' => $store->id,
            'equipament_id' => $equipaments[0]->id,
            'budget' => 50,
            'fail_description' => 'Cellphone not Chargeing',
        ];
    }

    /**
     * @test
     *
     * @return void
     */
    public function should_create_invoice()
    {
        //arrange
        $dataInvoice = $this->getInvoiceData();

        //act
        $result = RepairInvoice::factory()->create($dataInvoice);

        //assert
        $this->assertInstanceOf(RepairInvoice::class, $result);
        $this->assertDatabaseHas('repair_invoices', $dataInvoice);

    }
}
