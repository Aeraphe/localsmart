<?php

namespace Database\Seeders\Permissions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionFactory
{
    use RefreshDatabase;

    public static $permissions = [];

    public static $guards = [ 'api','web', 'employee'];

    public static $module = 'admin';

    public static $scope = '';

    public static function create()
    {
        static::createPermissions();
        static::signPermissionToRoles();
    }

    private static function createPermissions()
    {

        foreach (static::$permissions as $key => $item) {

            foreach (static::$guards as $guard) {

                $permission = [
                    'name' => $item['name'] . "_" . static::$scope,
                    'description' => $item['description'],
                    'guard_name' => $guard,
                    'module' => static::$module,
                ];
                DB::table('permissions')->insert($permission);

            }
        };
    }

    private static function signPermissionToRoles()
    {
        foreach (static::$permissions as $key => $item) {
            $rule = $item['name'] . "_" . static::$scope;
            $permissions = Permission::where('name', $rule)->get();
            foreach ($permissions as $permission) {
                $permission->syncRoles($item['roles']);
            }
        }

    }

}
