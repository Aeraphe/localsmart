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
        $actions = ['create', 'edit', 'delete', 'show'];
        $scopes = ['employee', 'invoice', 'equipament', 'store', 'account', 'gadget'];
        $roles = ['super-admin', 'admin', 'repair', 'seller', 'gadget-admin'];

        //Create all app Roles
        $this->createAppRoles($roles);
        //Create App Permissions
        $this->createPermissions($actions, $scopes);

        //Default Module
        $this->signPermissionsToRoles($scopes, $actions, ['admin']);
        $this->signPermissionsToRoles(['invoice', 'equipament'], $actions, ['repair', 'seller']);
        //Gadget Module
        $this->signPermissionsToRoles(['gadget'], $actions, ['gadget-admin']);

    }

    private function createAppRoles($roles)
    {

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
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
                $permission = Permission::create(['name' => $permissionName]);
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

        $appPermissions = Permission::all();

        foreach ($actions as $action) {

            foreach ($scopes as $scope) {

                $appPermissions->firstWhere('name', $action . '_' . $scope)->syncRoles($roles);

            }

        }

    }

}
