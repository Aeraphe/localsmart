<?php

namespace Tests\Feature\Models;

use App\Models\Account;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    /**
     * Fixture User Data For create User module
     */
    private function getUserData()
    {
        return [
            'name' => 'Maria Dalva de Castro',
            'email_verified_at' => '2009-12-01 00:00:00',
            'password' => 'password',
            'remember_token' => '123456789',
        ];
    }
    /**
     * Fixture for Account Model
     */
    private function getAccountData($userId)
    {
        return [
            'plan_name' => 'free',
            'plan_status' => true,
            'store_qt' => 1,
            'user_id' => $userId,
            'slug' => 'localsmart',
        ];
    }

    /**
     * Teste create a user
     * @test
     *
     * @return void
     */
    public function create_new_user()
    {
        //arrange
        $userData = $this->getUserData();

        //act
        $user = User::factory()->create($userData);

        //assert
        $this->assertInstanceOf(User::class, $user, "create a user model");
        $this->assertDatabaseHas('users', $userData);

    }

    /**
     * @test
     */
    public function delete_user()
    {

        //arrange
        $userData = $this->getUserData();
        $userId = User::factory()->create($userData)->id;
        $user = User::find($userId);

        //act
        $user->delete();

        //assert
        $this->assertDatabaseMissing('users', $userData);

    }

    /**
     * @test
     */
    public function should_user_has_account()
    {

        //arrange
        $userData = $this->getUserData();
        $sut = User::factory()->create($userData);
        Account::create($this->getAccountData($sut->id));

        //act
        $account = $sut->account;

        //assert
        $this->assertInstanceOf(Account::class, $account);

    }

   
}
