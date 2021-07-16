<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticateService
{

    /**
     * Authenticate Account Users
     *
     * @param array $credentials
     * @return \App\Models\User | false
     */
    public static function athenticateAccountUser($credentials)
    {
        $user = User::where('email', $credentials['email'])->firstOrFail();

        if (Hash::check($credentials['password'], $user->password)) {

            return $user;

        };

        return false;
    }

}
