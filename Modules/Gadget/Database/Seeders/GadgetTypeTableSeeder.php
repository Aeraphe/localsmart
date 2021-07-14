<?php

namespace Modules\Gadget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Gadget\Entities\GadgetType;

class GadgetTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        GadgetType::create(['name' => 'celular']);
        GadgetType::create(['name' => 'tablet']);
        GadgetType::create(['name' => 'computador']);
        GadgetType::create(['name' => 'monitor']);

        // $this->call("OthersTableSeeder");
    }
}
