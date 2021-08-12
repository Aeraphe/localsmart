<?php

namespace Database\Seeders\Permissions\Admin;

use Database\Seeders\Permissions\PermissionFactory;

class RolePermissionFactory extends PermissionFactory{


    public static $module = 'admin';

    public static $scope = 'role';

    public static $permissions = [

        [
            "name" => 'create',
            "description" => 'Adicionar um novo tipo de Usuário',
            'roles' => ['admin'],
        ],
        [
            "name" => 'delete',
            "description" => 'Apagar tipo de Usuário',
            'roles' => ['admin'],
        ],
        [
            "name" => 'show',
            "description" => 'Ver tipo de Usuário',
            'roles' => ['admin'],
        ],
        [
            "name" => 'show_all',
            "description" => 'Listar todos os tipos de Usuários',
            'roles' => ['admin'],
        ],
        [
            "name" => 'update',
            "description" => 'Atualizar o tipo de Usuário',
            'roles' => ['admin'],
        ],
        [
            "name" => 'sign',
            "description" => 'Atribuir tipo usuário ao Funcionário',
            'roles' => ['admin'],
        ],

    ];




}