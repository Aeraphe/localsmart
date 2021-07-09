<?php

namespace Tests\Feature\Models;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    private function getAccountPlanData($userId)
    {
        return [
            'plan_name' => 'free',
            'plan_status' => true,
            'store_qt' => 1,
            'user_id' => $userId,
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
        $user = User::factory()->create();
        $data = $this->getAccountPlanData($user->id);

        //act
        $account = Account::create($data);

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
        $user = User::factory()->create();
        $data = $data = $this->getAccountPlanData($user->id);
        $account = Account::create($data);

        //act
        $account->delete();

        //assert
        $this->assertInstanceOf(Account::class, $account);
        $this->assertDatabaseMissing('accounts', $data);

    }

}
