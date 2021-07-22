<?php

namespace App\Services;

use App\Exceptions\AuthenticateAccountUser\AuthenticateEmailException;
use App\Exceptions\AuthenticateAccountUser\AuthenticatePasswordException;
use App\Models\Account;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

        try {
            //Check if the user exists for the given e-mail or fail if not
            $user = User::where('email', $credentials['email'])->firstOrFail();

            //If the user exists check the password else throw an exception
            if (Hash::check($credentials['password'], $user->password)) {
                //Create new access token and set it to the current user
                $user->withAccessToken($user->createToken('maria dalva de castro oliveira')->accessToken);

                return $user;
            } else {

                throw new AuthenticatePasswordException('Não foi possivel localizar o usuário com a senha fornecida', 403);

            }
        } catch (ModelNotFoundException) {

            throw new AuthenticateEmailException('Não foi possivel localizar o usuário com o email fornecido', 404);

        }

    }

    public static function authenticateEmployeUser($credentials, $accountSlug, $storeSlug)
    {

        $account = Account::where('slug', $accountSlug)->firstOrFail();

        $employeQuery = [['login_name', '=', $credentials['login_name']], ['account_id', '=', $account->id]];
        $employe = Staff::where($employeQuery)->firstOrFail();

        $stores = $employe->stores;

        $store = $stores->firstWhere('slug', $storeSlug);

        if (Hash::check($credentials['password'], $employe->password) && $store->status) {

            return $employe;
        };

        return false;

    }

}
