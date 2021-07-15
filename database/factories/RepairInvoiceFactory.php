<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Equipament;
use App\Models\RepairInvoice;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepairInvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RepairInvoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $customer = Customer::factory()->has(Equipament::factory()->count(1), 'equipaments')->create();
        $equipaments = $customer->equipaments;

        return [
            'store_id' => Store::factory(),
            'equipament_id' => $equipaments[0]->id,
            'budget' => $this->faker->randomNumber(2),
            'fail_description' => 'Cellphone not Chargeing',
        ];
    }
}
