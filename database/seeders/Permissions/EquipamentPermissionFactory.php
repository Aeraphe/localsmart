<?php
namespace Database\Seeders\Permissions;

class EquipamentPermissionFactory extends PermissionFactory
{

    public static $module = 'invoice';

    public static $scope = 'equipament';

    public static $permissions = [

        [
            "name" => 'create',
            "description" => 'Adicionar um novo equipamento para o cliente',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'delete',
            "description" => 'Apagar o equipamento do cliente',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'show',
            "description" => 'Ver o equipamento do cliente',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'show_all',
            "description" => 'Listar todos os equipamentos do cliente',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'update',
            "description" => 'Atualizar os dados do equipamento do cliente',
            'roles' => ['admin', 'seller', 'repair'],
        ],

    ];

}
