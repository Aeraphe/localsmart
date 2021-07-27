<?php

namespace Tests\Feature\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Equipament;
use App\Models\InvoiceEquipamemtInspection;
use App\Models\InvoiceEquipamentCondition;
use App\Models\RepairInvoice;
use App\Models\RepairInvoiceStatus;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\Feature\Helpers;
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
     * Get invoice with user logged
     *
     * @param [type] $permission
     * @return void
     */
    private function getInvoiceWithUserLogged(string $permission): RepairInvoice
    {
        $user = Helpers::getEmployeeLoggedWithAccount($permission);
        $store = $user->stores()->first();
        $customer = Customer::factory()->has(Equipament::factory()->count(1))->create(['account_id' => $user->account->id]);

        $invoice = RepairInvoice::factory()->create(['store_id' => $store->id, 'equipament_id' => $customer->equipaments[0]->id]);

        InvoiceEquipamemtInspection::create([
            'name' => 'Wifi checked',
            'equipament_id' => $customer->equipaments[0]->id,
            'repair_invoice_id' => $invoice->id,

        ]);

        InvoiceEquipamentCondition::create([
            'name' => 'Broked display',
            'equipament_id' => $customer->equipaments[0]->id,
            'repair_invoice_id' => $invoice->id,

        ]);

        RepairInvoiceStatus::factory()->create(['repair_invoice_id' => $invoice->id]);

        return $invoice;
    }

    /**
     * @test
     * @group invoice
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
        $employee->givePermissionTo('create_repair_invoice');
        $customer = Customer::factory()->has(Equipament::factory()->count(1))->create(['account_id' => $account_id]);
        $equipaments = $customer->equipaments;

        $postData = [
            'store_id' => $store->id,
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

    /**
     * @test
     * @group invoice
     *
     * @return void
     */
    public function should_edit_rapir_invoice()
    {
        //arrange
        $user = Helpers::getEmployeeLoggedWithAccount('edit_repair_invoice');
        $store = $user->stores()->first();
        $invoice = RepairInvoice::factory()->create(['store_id' => $store->id]);

        $postData = ['id' => $invoice->id, 'fail_description' => 'Charge connectos is broke'];
        $route = '/api/v1/store/repair-invoice';

        $responseData = Helpers::makeResponseApiMock('Dados atualizados com sucesso', 200, ['id' => $invoice->id], $route, "PUT");

        //act
        $response = $this->put($route, $postData);

        //assert
        $response->assertStatus(200);
        $response->assertJson($responseData);
        $this->assertDatabaseHas('repair_invoices', $postData);

    }

    /**
     * @test
     * @group invoice
     */
    public function should_delete_repair_invoice()
    {
        //arrange
        $user = Helpers::getEmployeeLoggedWithAccount('delete_repair_invoice');
        $store = $user->stores()->first();
        $invoice = RepairInvoice::factory()->create(['store_id' => $store->id]);

        $postData = ['id' => $invoice->id];
        $route = '/api/v1/store/repair-invoice';

        $responseData = Helpers::makeResponseApiMock('Ordem de serviço apagada com sucesso', 200, ['id' => $invoice->id], $route, "DELETE");

        //act
        $response = $this->delete($route, $postData);

        //assert
        $response->assertStatus(200);
        $response->assertJson($responseData);
        $this->assertDatabaseMissing('repair_invoices', $postData);
    }
}
