<?php
namespace Modules\Gadget\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Gadget\Entities\GadgetType;
use Modules\Gadget\Entities\Manufacturer;

class GadgetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Gadget\Entities\Gadget::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'gadget_type_id' => GadgetType::factory(),
            'manufacturer_id' => Manufacturer::factory(),
        ];
    }
}

