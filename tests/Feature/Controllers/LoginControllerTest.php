<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{

    use RefreshDatabase;
    /**
     * @test
     *
     * @return void
     */
    public function should_admin_user_authenticate()
    {
        //arrange
        $password = '123';
        $data = ['email' => 'alberto.aeraph@gmail.com', 'password' => Hash::make($password)];
        User::factory()->create($data);

        //act
        $response = $this->post('/admin/login',
            ['email' => 'alberto.aeraph@gmail.com', 'password' => $password]);

        //assert
        $response->assertStatus(200);

    }
}
