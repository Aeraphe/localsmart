<?php
namespace Modules\Gadget\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RepairFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Gadget\Entities\Repair::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return  [
            'name' => $this->faker->name,
            'operation' => 'solda',
            'description' => 'Retirar o display com cuidado para não quebrar',
            'dificult' => 3,
        ];
    }
}

