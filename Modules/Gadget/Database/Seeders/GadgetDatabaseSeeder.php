<?php

namespace Modules\Gadget\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class GadgetDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(ManufacturerTableSeeder::class);
        $this->call(GadgetTypeTableSeeder::class);
    }
}
