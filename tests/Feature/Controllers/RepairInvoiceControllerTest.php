<?php

namespace Tests\Feature\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Equipament;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;

class RepairInvoiceControllerTest extends TestCase
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
     *@test
     *
     * @return void
     */
    public function can_create_a_repair_invoice()
    {

        //arrange
        $store = Store::factory()->create();
        $account_id = $store->account->id;
        $employee = Employee::factory()->create(['account_id' => $account_id]);
        $employee->stores()->attach($store->id);
        Passport::actingAs($employee);
        $employee->givePermissionTo('create_invoice');
        $customer = Customer::factory()->has(Equipament::factory()->count(1))->create(['account_id' => $account_id]);
        $equipaments = $customer->equipaments;

        $postData = [
            'store_id' => $store->id,
            'customer_id' => $customer->id,
            'equipament_id' => $equipaments[0]->id,
            'budget' => 50,
            'conditions' => ['Without test condition', 'Wifi is not turning on', 'Some scratches on screen'],
            'inspections' => ['Touch Id', 'Wifi', 'Structure'],
            'fail_description' => 'Cellphone not Chargeing',
        ];

        //act
        $response = $this->post('/api/v1/store/repair-invoice', $postData);

        //assert
        $response->assertStatus(200);
        $this->assertDatabaseHas('repair_invoices', ['fail_description' => $postData['fail_description']]);
        $this->assertDatabaseHas('invoice_equipament_conditions', ['name' => $postData['conditions']]);
        $this->assertDatabaseHas('invoice_equipamemt_inspections', ['name' => $postData['inspections']]);
        $this->assertDatabaseHas('repair_invoice_statuses', ['description' => 'Primeiro status', 'status' => 1]);
    }
}
