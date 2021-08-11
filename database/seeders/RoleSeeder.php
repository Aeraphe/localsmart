<?php

namespace Database\Seeders;

use Database\Seeders\Permissions\AccountPermissionFactory;
use Database\Seeders\Permissions\CustomerPermissionFactory;
use Database\Seeders\Permissions\EmployeePermissionFactory;
use Database\Seeders\Permissions\EquipamentConditionPermissionFactory;
use Database\Seeders\Permissions\EquipamentInspectionPermissionFactory;
use Database\Seeders\Permissions\EquipamentPermissionFactory;
use Database\Seeders\Permissions\Gadget\GadgetPermissionFactory;
use Database\Seeders\Permissions\RepairInvoicePermissionFactory;
use Database\Seeders\Permissions\RepairInvoiceStatusPermissionFactory;
use Database\Seeders\Permissions\StorePermissionFactory;
use Database\Seeders\Permissions\UserPermissionFactory;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roles = [
            ['name' => 'super-admin', 'description' => 'Super Administrador', 'module' => 'super-admin'],
            ['name' => 'admin', 'description' => 'Administrador', 'module' => 'admin'],
            ['name' => 'repair', 'description' => 'Tećnico', 'module' => 'invoice'],
            ['name' => 'seller', 'description' => 'Vendedor', 'module' => 'invoice'],
            ['name' => 'gadget-admin', 'description' => 'Administrador do módulo de Gadgets', 'module' => 'gadget'],
        ];

        //Create all app Roles
        $this->createAppRoles($roles);
        //Create App Permissions
        EmployeePermissionFactory::create();
        RepairInvoicePermissionFactory::create();
        RepairInvoiceStatusPermissionFactory::create();
        EquipamentPermissionFactory::create();
        AccountPermissionFactory::create();
        StorePermissionFactory::create();
        CustomerPermissionFactory::create();
        UserPermissionFactory::create();
        EquipamentConditionPermissionFactory::create();
        EquipamentInspectionPermissionFactory::create();
        GadgetPermissionFactory::create();

    }

    private function createAppRoles($roles)
    {

        foreach ($roles as $role) {
            Role::create(['guard_name' => 'api', 'name' => $role['name'], 'description' => $role['description'], 'module' => $role['module']]);
            Role::create(['guard_name' => 'web', 'name' => $role['name'], 'description' => $role['description'], 'module' => $role['module']]);
            Role::create(['guard_name' => 'employee', 'name' => $role['name'], 'description' => $role['description'], 'module' => $role['module']]);
        }
        ;
    }

}
