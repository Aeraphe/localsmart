<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Employee;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Laravel\Passport\Passport;

class Helpers
{

    public static function getEmployeeLoggedWithAccount(string $permission = '')
    {

        $account = Account::factory()->create();
        $user = Employee::factory()->create(['account_id' => $account->id]);
        $store = Store::factory()->create(['account_id' => $account->id]);
        $user->stores()->attach($store->id);
        Passport::actingAs($user);
        $user->givePermissionTo($permission);

        return $user;
    }

    public static function getAccountUserLoggedWithAccount(string $permission = '')
    {

        $user = User::factory()->create();
        $account = Account::factory()->create(['user_id' => $user->id]);
        Store::factory()->create(['account_id' => $account->id]);
        Passport::actingAs($user);
        $user->givePermissionTo($permission);
        return $user;
    }

    public static function makeResponseApiMock(string $message,int $status,array $data,string $route,$method)
    {
        return [
            'data' => $data,
            '_message' => $message,
            '_status' => $status,
            '_url' => Config::get('app.url') . $route,
            '_method' => $method,
        ];
    }

}
