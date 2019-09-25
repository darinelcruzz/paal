<?php

return [

    'providers' => [
        'title' => 'Proveedores',
        'icon' => 'fa fa-truck',
        'route' => 'paal.provider.index'
    ],

    'ingresses' => [
        'title' => 'Ingresos',
        'icon' => 'fa fa-shopping-cart',
        'submenu' => [
            'daily' => [
                'title' => 'Corte diario',
                'route' => ['paal.ingress.daily', 'coffee']
            ],
            'index' => [
                'title' => 'Historial',
                'route' => 'paal.ingress.index'
            ]
        ]
    ],

    'egresses' => [
        'title' => 'Egresos',
        'icon' => 'fa fa-share',
        'submenu' => [
            'monthly' => [
                'title' => 'Corte mensual',
                'route' => 'paal.egress.monthly'
            ],
            'index' => [
                'title' => 'Historial',
                'route' => ['paal.egress.index', 'coffee']
            ]
        ]
    ],

    'clients' => [
        'title' => 'Clientes',
        'icon' => 'fa fa-user',
        'route' => 'paal.client.index'
    ],

    'users' => [
        'title' => 'Usuarios',
        'icon' => 'fa fa-key',
        'route' => 'paal.user.index'
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
        'icon' => 'fa fa-door-open',
        'route' => 'logout'
    ],
];
