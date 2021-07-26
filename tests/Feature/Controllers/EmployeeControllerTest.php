<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
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
        $this->assertDatabaseMissing('employees',['id' => $employee->id]);

    }

}
