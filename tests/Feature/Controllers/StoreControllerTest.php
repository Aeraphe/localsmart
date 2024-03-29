<?php

namespace Tests\Feature\Controllers;

use App\Models\Store;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\Feature\Helpers;
use Tests\TestCase;

class StoreControllerTest extends TestCase
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

    /**
     * @test
     * @group store
     *
     * @return void
     */
    public function should_show_all_store()
    {
        //arrange
        $user = Helpers::getAccountUserLoggedWithAccount('show_all_store');
        $route = '/api/v1/store';
        $storeResponseData = $user->account->stores->toArray();
        $responseData = Helpers::makeResponseApiMock('Consulta realizada com sucesso', 200, $storeResponseData, $route, "GET");

        //act
        $response = $this->get($route);

        //assert
        $response->assertStatus(200);
        $response->assertJson($responseData);
    }

    /**
     * @test
     * @group store
     *
     * @return void
     */
    public function should_employee_show_store()
    {
        //arrange
        $user = Helpers::getEmployeeLoggedWithAccount('show_store');
        $route = '/api/v1/store/' . $user->account->stores[0]->id;
        $storeResponseData = $user->account->stores[0]->toArray();
        $responseData = Helpers::makeResponseApiMock('Consulta realizada com sucesso', 200, $storeResponseData, $route, "GET");

        //act
        $response = $this->get($route);

        //assert
        $response->assertStatus(200);
        $response->assertJson($responseData);
    }

    /**
     * @test
     * @group store
     *
     * @return void
     */
    public function should_create_store()
    {
        //arrange
        $user = Helpers::getAccountUserLoggedWithAccount('create_store');
        $user->account->store_qt = 3;
        $postData = [
            'name' => $this->faker->company,
            'slug' => $this->faker->slug,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
        ];
        $route = '/api/v1/store';

        //act
        $response = $this->post($route, $postData);

        //assert
        $response->assertStatus(200);
        $this->assertDatabaseHas('stores', $postData);

    }

    /**
     * @test
     * @group store
     *
     * @return void
     */
    public function should_fail_on_create_store_for_account_store_quantity_exceeds()
    {

        //arrange
        $user = Helpers::getAccountUserLoggedWithAccount('create_store');
        $user->account->store_qt = 1;
        $postData = [
            'name' => $this->faker->company,
            'slug' => $this->faker->slug,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
        ];
        $route = '/api/v1/store';

        //act
        $response = $this->post($route, $postData);
        $response->assertStatus(403);

    }

    /**
     * @test
     * @group store
     *
     * @return void
     */
    public function should_fail_on_create_store_with_same_slug()
    {

        //arrange
        $user = Helpers::getAccountUserLoggedWithAccount('create_store');
        $store = $user->account->stores[0];
        Store::where('id', $store->id)->update(['slug' => "local-smart"]);

        $user->account->store_qt = 2;
        $postData = [
            'name' => $this->faker->company,
            'slug' => "local-smart",
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
        ];
        $route = '/api/v1/store';

        //act
        $response = $this->post($route, $postData);
        $response->assertStatus(403);

    }

    /**
     * @test
     * @group store
     *
     * @return void
     */
    public function should_update_store()
    {

        //arrange
        $user = Helpers::getAccountUserLoggedWithAccount('update_store');
        $store = $user->account->stores[0];

        $postData = [
            'id' => $store->id,
            'name' => $this->faker->company,
            'slug' => $this->faker->slug,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
        ];
        $route = '/api/v1/store';

        $responseData = Helpers::makeResponseApiMock('Atualizada com sucesso', 200, ['id' => $store->id], $route, 'PUT');

        //act
        $response = $this->put($route, $postData);

        //assert
        $response->assertStatus(200);
        $response->assertSimilarJson($responseData);

    }

    /**
     * @test
     * @group store
     *
     * @return void
     */
    public function should_delete_store()
    {

        //arrange
        $user = Helpers::getAccountUserLoggedWithAccount('delete_store');
        $store = $user->account->stores[0];

        $postData = [
            'id' => $store->id,

        ];
        $route = '/api/v1/store';

        $responseData = Helpers::makeResponseApiMock('Loja apagada com sucesso', 200, ['id' => $store->id], $route, 'DELETE');

        //act
        $response = $this->delete($route, $postData);

        //assert
        $response->assertStatus(200);
        $response->assertSimilarJson($responseData);
        $this->assertDatabaseMissing('stores', $postData);

    }

    /**
     * @test
     * @group store
     *
     */
    public function should_sign_employee_to_store()
    {
        //arrange
        $user = Helpers::getAccountUserLoggedWithAccount('sign_store');
        $store = $user->account->stores[0];
        $employee = $user->account->employees[0];

        $postData = [
            'store_id' => $store->id,
            'employee_id' => $employee->id,
        ];
        $route = '/api/v1/store/sign/employee';

        $responseData = Helpers::makeResponseApiMock('Acesso Liberado a Loja', 200, $postData, $route, 'POST');

        //act
        $response = $this->post($route, $postData);

        //assert
        $response->assertStatus(200);
        $response->assertSimilarJson($responseData);
        $this->assertDatabaseHas('employee_store', $postData);

    }

    /**
     * @test
     * @group store-i
     *
     */
    public function should_unsign_employee_to_store()
    {
        //arrange
        $user = Helpers::getAccountUserLoggedWithAccount('unsign_store');
        $store = $user->account->stores[0];
        $employee = $user->account->employees[0];
        $store->employees()->attach($employee->id);
        $postData = [
            'store_id' => $store->id,
            'employee_id' => $employee->id,
        ];
        $route = '/api/v1/store/unsign/employee';

        $responseData = Helpers::makeResponseApiMock('Acesso do Funcionárioa a Loja Cancelado', 200, $postData, $route, 'DELETE');

        //act
        $response = $this->delete($route, $postData);

        //assert
        $response->assertStatus(200);
        $response->assertSimilarJson($responseData);
        $this->assertDatabaseMissing('employee_store', $postData);

    }

}
