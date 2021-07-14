<?php

namespace Modules\Gadget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Gadget\Entities\Manufacturer;

class ManufacturerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Manufacturer::create(['name' => 'Apple']);
        Manufacturer::create(['name' => 'Samsung']);
        Manufacturer::create(['name' => 'Xiaomi']);
        Manufacturer::create(['name' => 'Assus']);
        Manufacturer::create(['name' => 'LG']);
        
        // $this->call("OthersTableSeeder");
    }
}
