<?php

namespace Database\Seeders\Permissions;

class EquipamentConditionPermissionFactory extends PermissionFactory
{

    public static $module = 'invoice';

    public static $scope = 'equipament_condition';

    public static $permissions = [

        [
            "name" => 'create',
            "description" => 'Adicionar uma nova condição de recebimento do equipamento',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'delete',
            "description" => 'Apagar uma condição de recebimento do equipamento',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'show',
            "description" => 'Ver a condição de recebimento do equipamento',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'show_all',
            "description" => 'Listar todas as condições de recebimento do equipamento',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'update',
            "description" => 'Atualizar a condição de recebimento do equipamento',
            'roles' => ['admin', 'seller', 'repair'],
        ],

    ];

}
