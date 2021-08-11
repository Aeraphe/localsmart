<?php

namespace Database\Seeders\Permissions;

class CustomerPermissionFactory extends PermissionFactory
{

    public static $module = 'invoice';

    public static $scope = 'customer';

    public static $permissions = [

        [
            "name" => 'create',
            "description" => 'Adicionar um novo cliente',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'delete',
            "description" => 'Apagar o cliente',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'show',
            "description" => 'Ver o cliente',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'show_all',
            "description" => 'Listar todos os clientes',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'update',
            "description" => 'Atualizar os dados do cliente',
            'roles' => ['admin', 'seller', 'repair'],
        ],

    ];

}
