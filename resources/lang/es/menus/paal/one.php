<?php

return [

    'providers' => [
        'title' => 'Proveedores',
        'icon' => 'fa fa-truck',
        'route' => 'paal.provider.index'
    ],

    'egresses' => [
        'title' => 'Egresos',
        'icon' => 'fa fa-share',
        'route' => 'paal.egress.index'
    ],

    'clients' => [
        'title' => 'Clientes',
        'icon' => 'fa fa-user',
        'route' => 'paal.client.index'
    ],

    'products' => [
        'title' => 'Productos',
        'icon' => 'fa fa-tag',
        'route' => 'paal.product.index'
    ],

    'reports' => [
        'title' => 'Reportes',
        'icon' => 'fa fa-bar-chart',
        'route' => 'paal.report.index'
    ],

    'logout' => [
        'title' => 'Salir',
        'icon' => 'fa fa-sign-out',
        'route' => 'logout'
    ],
];
