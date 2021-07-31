<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Employee;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create(['email' => 'test@test.com']);
        $account = Account::factory()->create(['user_id' => $user->id]);
        Employee::factory()->count(10)->create(['account_id' => $account->id]);
        Store::factory()->create(['account_id' => $account->id]);
        $user->assignRole('admin',);

    }
}
