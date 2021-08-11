<?php

namespace Database\Seeders\Permissions\Gadget;

use Database\Seeders\Permissions\PermissionFactory;

class GadgetPermissionFactory extends PermissionFactory
{

    public static $module = 'gadget';

    public static $scope = 'gadget-admin';

    public static $permissions = [

        [
            "name" => 'create',
            "description" => 'Adicionar ',
            'roles' => ['super-admin'],
        ],
        [
            "name" => 'delete',
            "description" => 'Apagar um',
            'roles' => ['super-admin'],
        ],
        [
            "name" => 'show',
            "description" => 'Ver ',
            'roles' => ['super-admin'],
        ],
        [
            "name" => 'show_all',
            "description" => 'Listar todas ',
            'roles' => ['super-admin'],
        ],
        [
            "name" => 'update',
            "description" => 'Atualizar ',
            'roles' => ['super-admin'],
        ],

    ];

}
