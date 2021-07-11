<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Staff::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_id' => Account::factory(),
            'name' => 'Ricardo',
            'phone' => $this->faker->name,
            'address' => $this->faker->address,
            'user' => 'ricardo',
            'password' => hash('sha256', 'password'),
        ];
    }
}