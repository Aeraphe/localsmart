<?php

namespace Tests\Feature\Services;

use App\Exceptions\AuthenticateAccountUser\AuthenticateEmailException;
use App\Exceptions\AuthenticateAccountUser\AuthenticatePasswordException;
use App\Models\User;
use App\Services\AuthenticateService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class AthenticateServiceTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }

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

    /**
     * @test
     *
     */
    public function should_account_user_authenticate_fail_for_wrong_email()
    {

        //arrange
        $user = User::factory()->create();

        //expect
        $this->expectException(AuthenticateEmailException::class);

        //act
        $resutl = AuthenticateService::athenticateAccountUser(['email' => 'aaaa@ddd.com', 'password' => 'password']);

    }

    /**
     * @test
     *
     */
    public function should_account_user_authenticate_fail_for_wrong_password()
    {

        //arrange
        $user = User::factory()->create();

        //assert
        $this->expectException(AuthenticatePasswordException::class);

        //act
        $resutl = AuthenticateService::athenticateAccountUser(['email' => $user->email, 'password' => 'wrong_password']);

    }
}
