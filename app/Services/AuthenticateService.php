<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Staff;
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
