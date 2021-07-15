<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use phpseclib3\Crypt\Random;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'plan_name' => 'free',
            'plan_status' => true,
            'store_qt' => 1,
            'user_id' => User::factory(),
            'slug' => $this->faker->slug,
        ];
    }
}
