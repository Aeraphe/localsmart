<?php

namespace Tests\Feature\Services;

use App\Models\User;
use App\Services\AuthenticateService;
use Tests\TestCase;

class AthenticateServiceTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function can_account_user_authenticate()
    {

        //arrange
        $user = User::factory()->create();

        //act
        $resutl = AuthenticateService::athenticateAccountUser(['email' => $user->email, 'password' => 'password']);

        //assert
        $this->assertInstanceOf(User::class, $resutl);

    }
}
