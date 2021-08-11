<?php

namespace Database\Seeders\Permissions;

class EquipamentInspectionPermissionFactory extends PermissionFactory
{

    public static $module = 'invoice';

    public static $scope = 'equipament_inspection';

    public static $permissions = [

        [
            "name" => 'create',
            "description" => 'Adicionar uma nova inspeção de recebimento do equipamento',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'delete',
            "description" => 'Apagar uma inspeção de recebimento do equipamento',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'show',
            "description" => 'Ver a inspeção de recebimento do equipamento',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'show_all',
            "description" => 'Listar todas as inspeções de recebimento do equipamento',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'update',
            "description" => 'Atualizar a inspeção de recebimento do equipamento',
            'roles' => ['admin', 'seller', 'repair'],
        ],

    ];

}
