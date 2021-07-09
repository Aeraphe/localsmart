<?php

namespace Tests\Feature\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase;

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

}
