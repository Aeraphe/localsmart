<?php

namespace Tests\Feature\Controllers;


use App\Models\Employee;
use App\Models\Store;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
        $this->seed(RoleSeeder::class);
    }

    /**
     * @test
     *
     * @return void
     */
    public function should_account_user_authenticate_with_api()
    {
        //arrange
        $password = '123';
        $data = ['email' => 'alberto.aeraph@gmail.com', 'password' => Hash::make($password)];
        User::factory()->create($data);

        //act
        $response = $this->post('/api/v1/account/login',
            ['email' => 'alberto.aeraph@gmail.com', 'password' => $password]);

        //assert
        $response->assertStatus(200);

    }

    /**
     * @test
     *
     * @return void
     */
    public function should_account_user_authenticate_with_api_fail_with_wrong_credentials()
    {
        //arrange
        $password = '123';
        $data = ['email' => 'alberto.aeraph@gmail.com', 'password' => Hash::make($password)];
        $user = User::factory()->create($data);

        $response = $this->post('/api/v1/account/login',
            ['email' => 'alberto.aeraph@gmail.com', 'password' => '']);

        //assert
        $response->assertStatus(302);

    }

    /**
     * @test
     *
     * @return void
     */
    public function should_account_user_authenticate_with_web()
    {
        //arrange
        $password = '123';
        $data = ['email' => 'alberto.aeraph@gmail.com', 'password' => Hash::make($password)];
        $user = User::factory()->create($data);

        //act
        $response = $this->post('/account/login',
            ['email' => 'alberto.aeraph@gmail.com', 'password' => $password]);

        //assert
        $response->assertStatus(200);
        $this->assertAuthenticated();
        $this->assertAuthenticatedAs($user, 'web');

    }

    /**
     * @test
     *
     * @return void
     */
    public function should_account_user_authenticate_with_web_fail_with_wrong_credentials()
    {
        //arrange
        $password = '123';
        $data = ['email' => 'alberto.aeraph@gmail.com', 'password' => Hash::make($password)];
        User::factory()->create($data);

        //act
        $response = $this->post('/account/login',
            ['email' => 'alberto.aeraph@gmail.com', 'password' => '']);

        //assert
        $response->assertStatus(302);
        $this->assertGuest();
        $response->assertSessionHasErrors(['password']);

    }

    /**
     * @test
     *
     */
    public function should_employe_user_authenticate_with_api()
    {

        //arrange

        $store = Store::factory()->create();
        $account = $store->account;

        $password = 'password';
        $empployeData = [
            'login_name' => 'alberto',
            'password' => Hash::make($password),
            'account_id' => $account->id,
        ];

        $employ = Employee::factory()->create($empployeData);

        //Set the employe to the store
        $employ->stores()->attach($store->id);

        $route = '/api/v1/login/' . $account->slug . '/' . $store->slug;

        $responseStructure = [
            'data' => [
                'store',
                'name',
            ],
        ];

        //act
        $response = $this->post($route, ['login_name' => $employ->login_name, 'password' => 'password']);

        //assert
        $response->assertStatus(200);
        $response->assertJsonStructure($responseStructure);

    }

    /**
     * @test
     *
     */
    public function should_employe_user_authenticate_with_api_fail_with_wrong_credentials()
    {

        //arrange

        $store = Store::factory()->create();
        $account = $store->account;

        $password = 'password';
        $empployeData = [
            'login_name' => 'alberto',
            'password' => Hash::make($password),
            'account_id' => $account->id,
        ];

        $employ = Employee::factory()->create($empployeData);

        //Set the employe to the store
        $employ->stores()->attach($store->id);

        $route = '/api/v1/login/' . $account->slug . '/' . $store->slug;


        //act
        $response = $this->post($route, ['login_name' => $employ->login_name, 'password' => '']);

        //assert
        $response->assertStatus(302);

    }

    /**
     * @test
     *
     */
    public function should_employe_user_authenticate_with_web()
    {

        //arrange

        $store = Store::factory()->create();
        $account = $store->account;

        $password = 'password';
        $empployeData = [
            'login_name' => 'alberto',
            'password' => Hash::make($password),
            'account_id' => $account->id,
        ];

        $employ = Employee::factory()->create($empployeData);

        //Set the employe to the store
        $employ->stores()->attach($store->id);

        $route = '/login/' . $account->slug . '/' . $store->slug;

        $responseStructure = [
            'data' => [
                'store',
                'name',
            ],
        ];

        //act
        $response = $this->post($route, ['login_name' => $employ->login_name, 'password' => 'password']);

        //assert
        $response->assertStatus(200);
        $response->assertJsonStructure($responseStructure);
        $this->assertAuthenticated();
        $this->assertAuthenticatedAs($employ, 'web');

    }

    /**
     * @test
     *
     */
    public function should_employe_user_authenticate_with_web_fail_with_wrong_credentials()
    {

        //arrange

        $store = Store::factory()->create();
        $account = $store->account;

        $password = 'password';
        $empployeData = [
            'login_name' => 'alberto',
            'password' => Hash::make($password),
            'account_id' => $account->id,
        ];

        $employ = Employee::factory()->create($empployeData);

        //Set the employe to the store
        $employ->stores()->attach($store->id);

        $route = '/login/' . $account->slug . '/' . $store->slug;

        //act
        $response = $this->post($route, ['login_name' => $employ->login_name, 'password' => '']);

        //assert
        $response->assertStatus(302);
        $this->assertGuest();
        $response->assertSessionHasErrors(['password']);

    }

}
