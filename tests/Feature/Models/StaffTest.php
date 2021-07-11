<?php

namespace Tests\Feature\Models;

use App\Models\Staff;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StaffTest extends TestCase
{

    use WithFaker, RefreshDatabase;
    /**
     * @test
     *
     * @return void
     */
    public function can_create_staff()
    {
        //arrange
        $staffData = [

            'name' => 'Ricardo',
            'phone' => $this->faker->name,
            'address' => $this->faker->address,
            'user' => 'ricardo',
            'password' => hash('sha256', 'password'),
        ];

        //act
        $staff = Staff::factory()->create($staffData);

        //assert
        $this->assertInstanceOf(Staff::class, $staff);
        $this->assertDatabaseHas('staff', $staffData);
    }
}
