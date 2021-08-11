<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\Employee;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Laravel\Passport\Passport;
use Tests\Feature\Helpers;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
        $this->seed(RoleSeeder::class);
        // now re-register all the roles and permissions (clears cache and reloads relations)
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();
    }

    private function getUserLoggedWithAccount()
    {

        $user = User::factory()->create();
        Account::factory()->create(['user_id' => $user->id]);
        Passport::actingAs($user);

        return $user;
    }

    /**
     * @test
     * @group  employee
     *
     * @return void
     */
    public function it_create_a_employee()
    {
        //arrange
        $account = Account::factory()->create();

        $user = $account->user;
        $user->givePermissionTo('create_employee');
        Passport::actingAs($user);

        $postData = [

            'name' => 'Ricardo',
            'phone' => $this->faker->name,
            'address' => $this->faker->address,
            'email' => $this->faker->email,
            'login_name' => 'ricardo',
            'password' => hash('sha256', 'password'),
        ];

        //act
        $response = $this->post('api/v1/account/employee', $postData);

        //assert
        $response->assertStatus(200);
        $this->assertDatabaseHas('employees', $postData);

    }

    /**
     * @test
     * @group  employee
     */
    public function should_fail_access_to_create_employee_for_unauthorized_user()
    {

        //arrange
        $user = User::factory()->create();
        Passport::actingAs($user);

        $postData = [

            'name' => 'Ricardo',
            'phone' => $this->faker->name,
            'address' => $this->faker->address,
            'email' => $this->faker->email,
            'login_name' => 'ricardo',
            'password' => hash('sha256', 'password'),
        ];

        //act
        $response = $this->post('api/v1/account/employee', $postData);
        //assert
        $response->assertStatus(500);
        $response->assertJsonFragment(['_message' => 'Operação não autorizada, entre em contato com o administrador do sistema']);
    }

    /**
     * @test
     * @group employee
     */
    public function can_delete_employee()
    {
        //arrange
        $user = $this->getUserLoggedWithAccount();
        $user->givePermissionTo('delete_employee');
        $employee = Employee::factory()->create(['account_id' => $user->account->id]);
        $route = '/api/v1/account/employee';

        //act
        $response = $this->delete($route, ['id' => $employee->id]);

        //assert
        $response->assertStatus(200);
        $this->assertDatabaseMissing('employees', ['id' => $employee->id]);

    }

    /**
     * @test
     * @group employee
     *
     * @return boolean
     */
    public function should_update_employee()
    {
        //arrange
        $user = $this->getUserLoggedWithAccount();
        $user->givePermissionTo('update_employee');
        $user->assignRole('admin');
        $employee = Employee::factory()->create(['account_id' => $user->account->id]);
        $route = '/api/v1/account/employee';

        $postData = [
            'id' => $employee->id,
            'name' => $this->faker->name,
        ];

        $responseData = [
            'data' => ['id' => $employee->id],
            '_message' => 'Dados atualizados com sucesso!!!',
            '_status' => 200,
            '_url' => Config::get('app.url') . $route,
            '_method' => "PUT",
        ];

        //act
        $response = $this->put($route, $postData);

        //assert
        $response->assertStatus(200);
        $response->assertJson($responseData);
        $this->assertDatabaseHas('employees', $postData);

    }

    /**
     * @test
     * @group employee
     *
     * @return boolean
     */
    public function should_get_employee()
    {
        //arrange
        $user = $this->getUserLoggedWithAccount();
        $user->assignRole('admin');
        $employee = Employee::factory()->create(['account_id' => $user->account->id]);
        $route = '/api/v1/account/employee/' . $employee->id;

      
        $responseData = [
            'data' => $employee->toArray(),
            '_message' => 'Consulta realizada com sucesso!!!',
            '_status' => 200,
            '_url' => Config::get('app.url') . $route,
            '_method' => "GET",
        ];
        //act
        $response = $this->get($route);
      
        //assert
        $response->assertStatus(200);
        $response->assertJson($responseData);
    }

    /**
     * @test
     * @group employee
     *
     * @return boolean
     */
    public function should_get__all_employees()
    {
        //arrange
        $user = $this->getUserLoggedWithAccount();
        $user->assignRole('admin');
        Employee::factory()->count(10)->create(['account_id' => $user->account->id]);
        $route = '/api/v1/account/employee';


        $responseData = [

            '_message' => 'Consulta realizada com sucesso!!!',
            '_status' => 200,
            '_url' => Config::get('app.url') . $route,
            '_method' => "GET",
        ];
        //act
        $response = $this->get($route);
        //assert
        $response->assertStatus(200);
        $response->assertJsonFragment($responseData);
    }

    /**
     * @test
     * @group employee
     *
     * @return boolean
     */
    public function should_new_emplyee_credential_be_valid()
    {
        //arrange
        $user = Helpers::getAccountUserLoggedWithAccount('create_employee');

        $route = '/api/v1/account/employee/credential/search';
        $postData = ['login_name' => $this->faker->name, 'account_id' => $user->account->id];
        $responseData = Helpers::makeResponseApiMock('Login valido', 200, ['credential' => true], $route, 'POST');

        //act
        $response = $this->post($route, $postData);
        //assert
        $response->assertStatus(200);
        $response->assertJson($responseData);
        $this->assertDatabaseMissing('employees', $postData);

    }


    /**
     * @test
     * @group employee
     *
     */
    public function should_change_employee_status()
    {
        //arrange
        $user= Helpers::getAccountUserLoggedWithAccount('create_employee');
        $employee = $user->account->employees[0];
        $postData = ['id'=> $employee->id,'status' =>'off'];
        $route = '/api/v1/account/employee/status';
        $responseData = Helpers::makeResponseApiMock('Status modificado com sucesso!!',200,$postData,$route,'PUT');
        //act
        $response =  $this->put($route,$postData);

        //assert
        $response->assertStatus(200);
        $response->assertJson($responseData);
        $this->assertDatabaseHas('employees',$postData);
    }

}
