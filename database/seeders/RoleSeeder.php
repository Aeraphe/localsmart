<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
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
        $actions = ['create', 'edit', 'delete', 'show', 'show_all', 'update'];
        $scopes = ['employee', 'repair_invoice', 'repair_invoice_status', 'equipament', 'equipament_condition', 'equipament_inspection', 'store', 'account', 'gadget', 'customer', 'user'];
        $roles = ['super-admin', 'admin', 'repair', 'seller', 'gadget-admin'];

        //Create all app Roles
        $this->createAppRoles($roles);
        //Create App Permissions
        $this->createPermissions($actions, $scopes);

        //Default Module
        $this->signPermissionsToRoles($scopes, $actions, ['admin']);

        //Gadget Module
        $this->signPermissionsToRoles(['gadget'], $actions, ['gadget-admin']);

    }

    private function createAppRoles($roles)
    {

        foreach ($roles as $role) {
            Role::create(['guard_name' => 'api', 'name' => $role]);
            Role::create(['guard_name' => 'web', 'name' => $role]);
            Role::create(['guard_name' => 'employee', 'name' => $role]);
        }
        ;
    }

    /**
     * Create all permissons for the given action and scope
     *
     * @param [type] $actions
     * @param [type] $scopes
     * @return void
     */
    private function createPermissions($actions, $scopes)
    {

        $appPermissions = [];
        foreach ($actions as $action) {
            foreach ($scopes as $scope) {
                $permissionName = $action . '_' . $scope;
                $permission = Permission::create(['guard_name' => 'api', 'name' => $permissionName]);
                $permission = Permission::create(['guard_name' => 'employee', 'name' => $permissionName]);
                $permission = Permission::create(['guard_name' => 'web', 'name' => $permissionName]);
                $appPermissions[$permissionName] = $permission;
            }
        }
        return $appPermissions;
    }

    /**
     * Sign Permissons to Roles by Scopes and Actions
     *
     * @param array $scopes
     * @param array $actions
     * @param array $roles
     * @return void
     */
    private function signPermissionsToRoles(array $scopes, array $actions, array $roles)
    {

        foreach ($actions as $action) {

            foreach ($scopes as $scope) {

                $permissions = Permission::where('name', $action . '_' . $scope)->get();
                foreach ($permissions as $perm) {
                    $perm->syncRoles($roles);
                }

            }

        }

    }

}
