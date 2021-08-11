<?php

namespace Database\Seeders\Permissions;

class EmployeePermissionFactory extends PermissionFactory
{

    public static $module = 'adm';

    public static $scope = 'employee';

    public static $permissions = [

        [
            "name" => 'create',
            "description" => 'Criar um novo Funcionário',
            'roles' => ['admin'],
        ],
        [
            "name" => 'delete',
            "description" => 'Apagar um Funcionário',
            'roles' => ['admin'],
        ],
        [
            "name" => 'show',
            "description" => 'Listar um Funcionário',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'show_all',
            "description" => 'Listar todos os Funcionários',
            'roles' => ['admin'],
        ],
        [
            "name" => 'update',
            "description" => 'Atualizar dados do Funcionário selecionado',
            'roles' => ['admin'],
        ],

    ];

}
