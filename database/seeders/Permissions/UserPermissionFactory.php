<?php

namespace Database\Seeders\Permissions;

class UserPermissionFactory extends PermissionFactory
{

    public static $module = 'admin';

    public static $scope = 'user';

    public static $permissions = [

        [
            "name" => 'create',
            "description" => 'Adicionar um novo Usuário',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'delete',
            "description" => 'Apagar o Usuário',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'show',
            "description" => 'Ver o Usuário',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'show_all',
            "description" => 'Listar todos os Usuários',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'update',
            "description" => 'Atualizar os dados do Usuário',
            'roles' => ['admin', 'seller', 'repair'],
        ],

    ];

}
