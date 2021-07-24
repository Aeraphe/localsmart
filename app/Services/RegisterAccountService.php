<?php

namespace App\Services;

use App\Exceptions\BaseException;
use App\Models\Account;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterAccountService
{

    public static function create($credentials)
    {

        try {

            $credentials['password'] = Hash::make($credentials['password']);
            $credentials['remember_token'] = Str::random(10);
            $user = User::create($credentials);
            //Add admin Role Authorization
            $user->assignRole('admin');
            //Create user account
            $account = Account::factory()->create(['user_id' => $user->id, 'slug' => 'smart10' . $user->id]);
            //Create a Store
            Store::factory()->create(['account_id' => $account->id, 'slug' => 'store10' . $account->id]);

            return $user;

        } catch (QueryException $e) {

            $exception = new BaseException('Erro ao efetuar a operção no banco de dados', $e->getCode());
            $exception->setData(['error' => $e->getMessage()]);

            throw $exception;

        }
    }

}
