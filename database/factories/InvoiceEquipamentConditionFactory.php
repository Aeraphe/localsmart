<?php

namespace Database\Factories;

use App\Models\InvoiceEquipamentCondition;
use App\Models\RepairInvoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceEquipamentConditionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoiceEquipamentCondition::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'repair_invoice_id' => RepairInvoice::factory(),
        ];
    }
}
