<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
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

    private function getLoggedEmployeeFormStore()
    {
        $employee = Employee::factory()->create();
        Passport::actingAs($employee);
        $employee->givePermissionTo('delete_customer');
        $accountId = $employee->account->id;
        $store = Store::factory()->create(['account_id' => $accountId]);
        $employee->stores()->attach($store->id);
        return $employee;
    }

    /**
     * @test
     *
     * @return void
     */
    public function should_create_customer()
    {

        //arrange
        $user = Account::factory()->create()->user;
        Passport::actingAs($user);
        $data = [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'cpf' => $this->faker->randomLetter,
            'rg' => $this->faker->randomLetter,
            'phone' => $this->faker->phoneNumber,
            'city' => $this->faker->city,
            'state' => $this->faker->country,
            'district' => $this->faker->address,
            'obs' => $this->faker->text,
        ];

        //act
        $result = $this->post('api/v1/account/customer', $data);

        //assert
        $result->assertStatus(200);
        $this->assertDatabaseHas('customers', $data);
        $result->assertJsonFragment([
            '_message' => 'Cliente Cadastrado com sucesso',
            'data' => ['name' => $data['name']],
        ]);

    }

    /**
     * @test
     *
     * @return boolean
     */
    public function should_soft_delete_a_customer()
    {
        //arrange
        $employee = $this->getLoggedEmployeeFormStore();
        $customer = Customer::factory()->create(['account_id' => $employee->account->id]);
        $store = $employee->stores->first();

        //act
        $sut = $this->delete('/api/v1/account/customer', ['id' => $customer->id, 'store_id' => $store->id]);

        //assert
        $sut->assertStatus(202);
        $this->assertSoftDeleted('customers', ['id' => $customer->id]);

    }

    /**
     * @test
     *
     * @return boolean
     */
    public function should_update_customer_data()
    {

        //arrange
        $employee = $this->getLoggedEmployeeFormStore();
        $employee->givePermissionTo('update_customer');
        $customer = Customer::factory()->create(['account_id' => $employee->account->id]);
        $putData = [

            'id' => $customer->id,
            'name' => "Alberto",
        ];

        //act
        $response = $this->put('/api/v1/account/customer', $putData);

        //assert
        $response->assertStatus(200);
        $this->assertDatabaseHas('customers', $putData);

    }

    /**
     * @test
     *
     * @return boolean
     */
    public function should_get_a_customer()
    {

        //arrange
        $employee = $this->getLoggedEmployeeFormStore();
        $employee->givePermissionTo('show_customer');
        $customer = Customer::factory()->create(['account_id' => $employee->account->id]);
        $route = '/api/v1/account/customer/' . $customer->id;
        
        $responseData = [
            'data' => $customer->toArray(),
            '_message' => "Consulta realizada com sucesso",
            '_status' => 200,
            '_url' =>  Config::get('app.url'). $route,
            '_method' => "GET",
        ];

        //act
        $response = $this->get($route);

        //assert
        $response->assertStatus(200);
        $response->assertJson($responseData);
    }

}
