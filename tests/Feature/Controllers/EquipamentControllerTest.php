<?php

namespace Tests\Feature\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Equipament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\Feature\Helpers;
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
     * @group equipament
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

    /**
     * @test
     * @group equipament
     */
    public function should_get_customer_equipament()
    {
        //arrange
        $user = Helpers::getEmployeeLoggedWithAccount('show_equipament');

        $customer = Customer::factory()->create(['account_id' => $user->account->id]);

        $equipament = Equipament::factory()->create(['customer_id' => $customer->id, 'name' => 'iPhone 10']);

        $route = '/api/v1/account/customer/equipament/' . $equipament->id;

        $responseDataFormat = Helpers::makeResponseApiMock(
            'Consulta Realizada com sucesso!!',
            200, $equipament->toArray(),
            $route,
            'GET'
        );

        //act
        $result = $this->get($route);

        //assert
        $result->assertStatus(200);
        $result->assertJson($responseDataFormat);
    }

    /**
     * @test
     * @group equipament
     *
     * @return boolean
     */
    public function should_get_all_customer_equipaments()
    {
        //arrange
        $user = Helpers::getEmployeeLoggedWithAccount('show_all_equipament');

        $customer = Customer::factory()->create(['account_id' => $user->account->id]);

        $equipaments = Equipament::factory()->count(5)->create(['customer_id' => $customer->id, 'name' => 'iPhone 10']);

        $route = '/api/v1/account/customer/equipament/all/' . $customer->id;

        $responseDataFormat = Helpers::makeResponseApiMock(
            'Consulta Realizada com sucesso!!',
            200, $equipaments->toArray(),
            $route,
            'GET'
        );

        //act
        $result = $this->get($route);

        //assert
        $result->assertStatus(200);
        $result->assertJson($responseDataFormat);
    }

    /**
     * @test
     * @group equipament
     *
     * @return boolean
     */
    public function should_edit_customer_equipament()
    {
        //arrange
        $user = Helpers::getEmployeeLoggedWithAccount('edit_equipament');
        $customer = Customer::factory()->create(['account_id' => $user->account->id]);
        $equipament = Equipament::factory()->create(['customer_id' => $customer->id]);
        $postData = ['id' => $equipament->id, 'name' => 'Samsung'];
        $route = '/api/v1/account/customer/equipament';
        $responseDataFormat = Helpers::makeResponseApiMock(
            'Atualização realizada com sucesso!!!',
            200,
            ['id' => $equipament->id]
            , $route,
            'PUT'
        );
        //act
        $result = $this->put($route, $postData);

        //assert
        $result->assertStatus(200);
        $result->assertJson($responseDataFormat);
        $this->assertDatabaseHas('equipaments', $postData);

    }

    /**
     * @test
     * @group equipament
     *
     * @return boolean
     */
    public function should_delete_customer_equipament()
    {
        //arrange
        $user = Helpers::getEmployeeLoggedWithAccount('delete_equipament');
        $customer = Customer::factory()->create(['account_id' => $user->account->id]);
        $equipament = Equipament::factory()->create(['customer_id' => $customer->id]);
        $postData = ['id' => $equipament->id];
        $route = '/api/v1/account/customer/equipament';
        $responseDataFormat = Helpers::makeResponseApiMock(
            'Equipamento apagado com sucesso!!!',
            200,
            ['id' => $equipament->id]
            , $route,
            'DELETE'
        );
        //act
        $result = $this->delete($route, $postData);

        //assert
        $result->assertStatus(200);
        $result->assertJson($responseDataFormat);
        $this->assertDatabaseMissing('equipaments', $postData);

    }

}
