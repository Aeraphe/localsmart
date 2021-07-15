<?php

namespace Database\Factories;

use App\Models\RepairInvoice;
use App\Models\RepairInvoiceStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepairInvoiceStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RepairInvoiceStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'repair_invoice_id' => RepairInvoice::factory(),
            'description' => 'Open',
            'status' => 1,
        ];

    }
}
