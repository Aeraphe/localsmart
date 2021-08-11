<?php

namespace Database\Seeders\Permissions;

class StorePermissionFactory extends PermissionFactory
{

    public static $module = 'admin';

    public static $scope = 'store';

    public static $permissions = [

        [
            "name" => 'create',
            "description" => 'Adicionar uma nova loja',
            'roles' => ['admin'],
        ],
        [
            "name" => 'delete',
            "description" => 'Apagar a loja',
            'roles' => ['admin'],
        ],
        [
            "name" => 'show',
            "description" => 'Ver a loja do cliente',
            'roles' => ['admin'],
        ],
        [
            "name" => 'show_all',
            "description" => 'Listar todos as lojas',
            'roles' => ['admin'],
        ],
        [
            "name" => 'update',
            "description" => 'Atualizar os dados da loja',
            'roles' => ['admin'],
        ],

    ];

}
