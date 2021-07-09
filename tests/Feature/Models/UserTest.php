<?php

namespace Tests\Feature\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Teste create a user
     * @test
     *
     * @return void
     */
    public function create_new_user()
    {
        //arrange
        $userName = "Maria Dalva de Castro";

        //act
        $user = User::factory()->create(['name' => $userName]);

        //assert
        $this->assertInstanceOf(User::class, $user, "create a user model");
        $this->assertDatabaseHas('users', ['name' => $userName]);

    }

    /**
     * @test
     */
    public function delete_user()
    {

        //arrange
        $userName = 'Alberto Eduardo de Oliveira' . rand();
        $user = User::factory()->create(['name' => $userName]);
        //act
        $user->delete();
        //assert
        $this->assertDatabaseMissing('users', ['name' => $userName]);

    }

}
