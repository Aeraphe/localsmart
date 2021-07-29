<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Tests\Feature\Helpers;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $user =  User::factory()->create(['email'=>'test@test.com']);
       $user->assignRole('admin');
    }
}
