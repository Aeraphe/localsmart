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

        $invoice = RepairInvoice::factory()->count(5)->create(['store_id' => $store->id, 'equipament_id' => $customer->equipaments[0]->id])[0];

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

    /**
     * @test
     * @group invoice
     */
    public function should_show_repair_invoice()
    {
        //arrange
        $invoice = $this->getInvoiceWithUserLogged('show_repair_invoice');

        $route = '/api/v1/store/repair-invoice/' . $invoice->id;

        $respInvoideWithEquipament = $invoice->with('status', 'conditions.equipament', 'inspections.equipament')->first();

        $reponseInvoiceData = $respInvoideWithEquipament->toArray();

        $responseData = Helpers::makeResponseApiMock('Operação realizada com sucesso!!!', 200, $reponseInvoiceData, $route, "GET");

        //act
        $response = $this->get($route);

        //assert
        $response->assertStatus(200);
        $response->assertJson($responseData);

    }

    /**
     * @test
     * @group invoice
     */
    public function should_show_all_repair_invoice()
    {
        //arrange
        $invoice = $this->getInvoiceWithUserLogged('show_all_repair_invoice');

        $route = '/api/v1/store/repair-invoice/all/' . $invoice->store->id;

        $reponseInvoiceData = $invoice->with('status', 'conditions.equipament', 'inspections.equipament')->get()->toArray();

        $responseData = Helpers::makeResponseApiMock('Operação realizada com sucesso!!!', 200, $reponseInvoiceData, $route, "GET");

        //act
        $response = $this->get($route);

        //assert
        $response->assertStatus(200);
        $response->assertJson($responseData);

    }

    /**
     * @test
     * @group invoice-equipament-conditions
     *
     * @return boolean
     */
    public function should_show_equipament_condition()
    {
        //arrange
        $invoice = $this->getInvoiceWithUserLogged('show_equipament_condition');

        $route = '/api/v1/store/repair-invoice/equipament/condition/' . $invoice->equipament->id;

        $responseData = Equipament::with('conditions', 'inspections')->where('id', $invoice->equipament->id)->get();

        $responseData = Helpers::makeResponseApiMock('Consulta realizada com sucesso!!!', 200, $responseData->toArray(), $route, "GET");

        //act
        $response = $this->get($route);

        //assert
        $response->assertStatus(200);
        $response->assertJson($responseData);

    }

    /**
     * @test
     * @group invoice-equipament-conditions
     *
     * @return boolean
     */
    public function should_add_equipament_condition()
    {
        //arrange
        $invoice = $this->getInvoiceWithUserLogged('create_equipament_condition');

        $route = '/api/v1/store/repair-invoice/equipament/condition';
        $postData = [
            'name' => 'Wifi checked',
            'equipament_id' => $invoice->equipament->id,
            'repair_invoice_id' => $invoice->id,
        ];

        $responseData = Helpers::makeResponseApiMock('Nova Condição Cadastrada com sucesso!!!', 200, $postData, $route, "POST");

        //act
        $response = $this->post($route, $postData);
        //assert
        $response->assertStatus(200);
        $this->assertDatabaseHas('invoice_equipament_conditions', $postData);
        $response->assertJson($responseData);

    }

    /**
     * @test
     * @group invoice-equipament-conditions
     *
     * @return boolean
     */
    public function should_delete_equipament_condition()
    {
        //arrange
        $invoice = $this->getInvoiceWithUserLogged('delete_equipament_condition');
        $conditions = $invoice->conditions;
        $route = '/api/v1/store/repair-invoice/equipament/condition';

        $postData = [
            'id' => $conditions[0]->id,
        ];

        $responseData = Helpers::makeResponseApiMock('Apagada com sucesso!!!', 200, $postData, $route, "DELETE");

        //act
        $response = $this->delete($route, $postData);

        //assert
        $response->assertStatus(200);
        $this->assertDatabaseMissing('invoice_equipament_conditions', $postData);
        $response->assertJson($responseData);

    }

    /**
     * @test
     * @group invoice-equipament-conditions
     *
     * @return boolean
     */
    public function should_update_equipament_condition()
    {
        //arrange
        $invoice = $this->getInvoiceWithUserLogged('update_equipament_condition');
        $conditions = $invoice->conditions;
        $route = '/api/v1/store/repair-invoice/equipament/condition';

        $postData = [
            'id' => $conditions[0]->id,
            'name' => 'Wifi checked',
        ];

        $responseData = Helpers::makeResponseApiMock('Condição Atualizada com sucesso!!!', 200, $postData, $route, "PUT");

        //act
        $response = $this->put($route, $postData);

        //assert
        $response->assertStatus(200);
        $this->assertDatabaseHas('invoice_equipament_conditions', $postData);
        $response->assertJson($responseData);

    }

    /**
     * @test
     * @group invoice-equipament-inspection
     *
     * @return boolean
     */
    public function should_add_equipament_inspection()
    {
        //arrange
        $invoice = $this->getInvoiceWithUserLogged('create_equipament_inspection');

        $route = '/api/v1/store/repair-invoice/equipament/inspection';
        $postData = [
            'name' => 'Wifi checked',
            'equipament_id' => $invoice->equipament->id,
            'repair_invoice_id' => $invoice->id,
        ];

        $responseData = Helpers::makeResponseApiMock('Nova Inspeção Cadastrada com sucesso!!!', 200, $postData, $route, "POST");

        //act
        $response = $this->post($route, $postData);
        //assert
        $response->assertStatus(200);
        $this->assertDatabaseHas('invoice_equipamemt_inspections', $postData);
        $response->assertJson($responseData);

    }

    /**
     * @test
     * @group invoice-equipament-inspection
     *
     * @return boolean
     */
    public function should_delete_equipament_inspection()
    {
        //arrange
        $invoice = $this->getInvoiceWithUserLogged('delete_equipament_inspection');
        $inspections = $invoice->inspections;
        $route = '/api/v1/store/repair-invoice/equipament/inspection';

        $postData = [
            'id' => $inspections[0]->id,
        ];

        $responseData = Helpers::makeResponseApiMock('Inspeção Apagada com sucesso!!!', 200, $postData, $route, "DELETE");

        //act
        $response = $this->delete($route, $postData);

        //assert
        $response->assertStatus(200);
        $this->assertDatabaseMissing('invoice_equipamemt_inspections', $postData);
        $response->assertJson($responseData);

    }

    /**
     * @test
     * @group invoice-equipament-inspection
     *
     * @return boolean
     */
    public function should_update_equipament_inspection()
    {
        //arrange
        $invoice = $this->getInvoiceWithUserLogged('update_equipament_inspection');
        $inspections = $invoice->inspections;
        $route = '/api/v1/store/repair-invoice/equipament/inspection';

        $postData = [
            'id' => $inspections[0]->id,
            'name' => 'Wifi checked',
        ];

        $responseData = Helpers::makeResponseApiMock('Inspeção Atualizada com sucesso!!!', 200, $postData, $route, "PUT");

        //act
        $response = $this->put($route, $postData);

        //assert
        $response->assertStatus(200);
        $this->assertDatabaseHas('invoice_equipamemt_inspections', $postData);
        $response->assertJson($responseData);

    }

    /**
     * @test
     * @group invoice-status
     *
     * @return boolean
     */
    public function should_show_invoice_status()
    {
        //arrange
        $invoice = $this->getInvoiceWithUserLogged('show_repair_invoice_status');

        $route = '/api/v1/store/repair-invoice/status/' . $invoice->id;

        $responseData = $invoice->status;

        $responseData = Helpers::makeResponseApiMock('Consulta realizada com sucesso!!!', 200, $responseData->toArray(), $route, "GET");

        //act
        $response = $this->get($route);

        //assert
        $response->assertStatus(200);
        $response->assertJson($responseData);

    }

}
