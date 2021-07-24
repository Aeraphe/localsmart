<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Equipament;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Gadget\Entities\Gadget;

class EquipamentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Equipament::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_id' => Customer::factory(),
            'name' => $this->faker->name,
            'gadget_id' => Gadget::factory(),

        ];
    }
}
