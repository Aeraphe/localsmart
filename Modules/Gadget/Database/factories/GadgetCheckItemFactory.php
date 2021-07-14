<?php
namespace Modules\Gadget\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Gadget\Entities\Gadget;

class GadgetCheckItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Gadget\Entities\GadgetCheckItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Verificar o TouchId',
            'gadget_id' => Gadget::factory(),
            'risk' => $this->faker->text,
            'procedure' => $this->faker->text,
            'level' => 'h',
        ];
    }
}
