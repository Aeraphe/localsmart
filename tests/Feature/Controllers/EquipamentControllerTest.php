<?php

namespace Tests\Feature\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;

class EquipamentControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
        $this->seed();
        // now re-register all the roles and permissions (clears cache and reloads relations)
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();
    }

    /**
     * @test
     *
     * @return void
     */
    public function should_add_equipament_to_customer()
    {

        //arrange
        $customer = Customer::factory()->create();
        $postData = ['name' => 'Samsung A30s', 'customer_id' => $customer->id, 'gadget_id' => 1];
        $employee = Employee::factory()->create();
        Passport::actingAs($employee);
        $employee->givePermissionTo('create_equipament');

        //act
        $response = $this->post('/api/v1/account/customer/equipament', $postData);

        //assert
        $response->assertStatus(200);
        $this->assertDatabaseHas('equipaments', $postData);
    }
}
