<?php

namespace Database\Seeders\Permissions;

class RepairInvoiceStatusPermissionFactory extends PermissionFactory
{

    public static $module = 'invoice';

    public static $scope = 'repair_invoice_status';

    public static $permissions = [

        [
            "name" => 'create',
            "description" => 'Criar um novo Status para a Ordem de Serviço',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'delete',
            "description" => 'Apagar um Status para da Ordem de Serviço',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'show',
            "description" => 'Listar o Status da Ordem de Serviço',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'show_all',
            "description" => 'Listar todos os Status da Ordem de Serviços',
            'roles' => ['admin', 'seller', 'repair'],
        ],
        [
            "name" => 'update',
            "description" => 'Atualizar o Status da Ordem de Serviço selecionada',
            'roles' => ['admin', 'seller', 'repair'],
        ],

    ];

}
