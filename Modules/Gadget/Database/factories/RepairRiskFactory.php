<?php
namespace Modules\Gadget\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Gadget\Entities\Repair;

class RepairRiskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Gadget\Entities\RepairRisk::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Quebra do display',
            'description' => '',
            'dificult' => 3,
            'repair_id' => Repair::factory(),
        ];
    }
}
