<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use \App\Exceptions\CutomException;

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
            $user = User::where('email', $credentials['email'])->firstOrFail();

            if (Hash::check($credentials['password'], $user->password)) {

                return $user;
            };

            $customException = new CutomException(
                'Não foi possivel localizar o usuário com o email fornecido',
                403,
                ['password' => 'credential not valid']
            );

            throw $customException;

        } catch (ModelNotFoundException) {
            $customException = new CutomException(
                'Não foi possivel localizar o usuário com o email fornecido',
                404,
                ['email' => 'email not found']
            );
            throw $customException;
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
