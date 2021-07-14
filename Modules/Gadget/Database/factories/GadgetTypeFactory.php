<?php
namespace Modules\Gadget\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GadgetTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Gadget\Entities\GadgetType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->slug,
        ];
    }
}
