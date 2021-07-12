<?php

namespace Tests\Feature\Models;

use App\Models\Account;
use App\Models\Customer;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    private function getAccountPlanData()
    {
        return [
            'plan_name' => 'free',
            'plan_status' => true,
            'store_qt' => 1,
            'slug' => 'localsmart',
        ];
    }

    /**
     * Create Account
     *@test
     * @return void
     */
    public function create_user_app_account()
    {
        //arrange
        $data = $this->getAccountPlanData();

        //act
        $account = Account::factory()->create($data);

        //assert
        $this->assertInstanceOf(Account::class, $account);
        $this->assertDatabaseHas('accounts', $data);

    }

    /**
     * @test
     */
    public function delete_user_app_account()
    {

        //arrange
        $data = $this->getAccountPlanData();
        $account = Account::factory()->create($data);

        //act
        $account->delete();

        //assert
        $this->assertInstanceOf(Account::class, $account);
        $this->assertDatabaseMissing('accounts', $data);

    }

    /**
     * @test
     */
    public function should_account_belongs_to_user()
    {
        //arrange
        $userId = User::factory()->create(['name' => 'carlos'])->id;
        $data = $this->getAccountPlanData();
        $data['user_id'] = $userId;
        $sut = Account::factory()->create($data);

        //act
        $user = $sut->user;

        //assert
        $this->assertEquals('carlos', $user->name);
        $this->assertInstanceOf(User::class, $user);

    }

    /**
     * Change Account Status to false
     * @test
     */
    public function should_change_account_status()
    {
        //arrange
        $sut = Account::factory()->create(['plan_status' => true]);

        //act
        $sut->changeAccountStatus(false);

        //assert
        $this->assertFalse($sut->plan_status);
    }

    /**
     * @test
     */
    public function should_get_customers_from_account()
    {

        //arrange
        $sut = Account::factory()->create();
        $customer = Customer::factory()->create(['account_id' => $sut->id]);

        //atc
        $result = $sut->customers;

        //assert
        $this->assertTrue($result->contains($customer));
    }

    /**
     * @test
     */
    public function check_if_can_create_the_firts_store()
    {
        //arrange
        $sut = Account::factory()->create();

        //act
        $result = $sut->canCreateStore();

        //assert
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function should_check_can_create_store_fail_on_exceed_account_plan_quantity()
    {
        //arrange
        $accountStoreQt = ['store_qt' => 1];
        $sut = Account::factory()
            ->has(Store::factory()->count(1))
            ->create($accountStoreQt);

        //act
        $result = $sut->canCreateStore();

        //assert
        $this->assertFalse($result);
    }

    /**
     * @test
     *
     */
    public function can_create_store_if_no_exceed_account_plan_quantity()
    {
        //arrange
        $accountStoreQt = ['store_qt' => 2];
        $sut = Account::factory()
            ->has(Store::factory()->count(1))
            ->create($accountStoreQt);

        //act
        $result = $sut->canCreateStore();

        //assert
        $this->assertTrue($result);
    }

}
