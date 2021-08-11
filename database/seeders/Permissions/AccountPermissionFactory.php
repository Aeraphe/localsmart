<?php

namespace Database\Seeders\Permissions;

class AccountPermissionFactory extends PermissionFactory
{

    public static $module = 'admin';

    public static $scope = 'account';

    public static $permissions = [

        [
            "name" => 'create',
            "description" => 'Adicionar um novo equipamento para o cliente',
            'roles' => ['admin'],
        ],
        [
            "name" => 'delete',
            "description" => 'Apagar a conta do cliente',
            'roles' => ['admin'],
        ],
        [
            "name" => 'show',
            "description" => 'Ver o conta do cliente',
            'roles' => ['admin'],
        ],
        [
            "name" => 'show_all',
            "description" => 'Listar todos os equipamentos do cliente',
            'roles' => ['admin'],
        ],
        [
            "name" => 'update',
            "description" => 'Atualizar os dados do equipamento do cliente',
            'roles' => ['admin'],
        ],

    ];

}
