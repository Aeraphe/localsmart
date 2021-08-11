<?php

namespace Database\Seeders\Permissions;

class RepairInvoicePermissionFactory extends PermissionFactory
{

    public static $module = 'invoice';

    public static $scope = 'repair_invoice';

    public static $permissions = [

        [
            "name" => 'create',
            "description" => 'Criar uma nova Ordem de Serviço',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'delete',
            "description" => 'Apagar uma Ordem de Serviço',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'show',
            "description" => 'Listar uma Ordem de Serviço',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'show_all',
            "description" => 'Listar todas as Ordem de Serviços',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'update',
            "description" => 'Atualizar dados da Ordem de Serviço selecionada',
            'roles' => ['admin', 'seller', 'repair'],
        ],

    ];

}
