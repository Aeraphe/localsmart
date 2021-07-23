<?php

namespace Tests\Feature\Models;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeTest extends TestCase
{

    use WithFaker, RefreshDatabase;
    /**
     * @test
     *
     * @return void
     */
    public function can_create_employee()
    {
        //arrange
        $data = [

            'name' => 'Ricardo',
            'phone' => $this->faker->name,
            'address' => $this->faker->address,
            'login_name' => 'ricardo',
            'password' => hash('sha256', 'password'),
        ];

        //act
        $employee = Employee::factory()->create($data);

        //assert
        $this->assertInstanceOf(Employee::class, $employee);
        $this->assertDatabaseHas('employees', $data);
    }
}
