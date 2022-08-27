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
        'route' => 'paal.ingress.index',
    ],

    'egresses' => [
        'title' => 'Egresos',
        'icon' => 'fa fa-share',
        'submenu' => [
            'general' => [
                'title' => 'Nuevo',
                'route' => 'paal.egress.create'
            ],
            'index' => [
                'title' => 'Historial',
                'route' => 'paal.egress.index'
            ],
            'cashier' => [
                'title' => 'Caja Chica',
                'route' => 'paal.egress.register.index'
            ],
        ]
    ],

    'financial-flow' => [
        'title' => 'Flujos financieros',
        'icon' => 'fa fa-wind',
        'submenu' => [
            'iva' => [
                'title' => 'I.V.A.',
                'route' => ['paal.financial-flow.index', 'iva']
            ],
            'subtotal' => [
                'title' => 'Subtotal',
                'route' => ['paal.financial-flow.index', 'subtotal']
            ]
        ]
    ],

    'clients' => [
        'title' => 'Clientes',
        'icon' => 'fa fa-user',
        'route' => 'paal.client.index'
    ],

    'logs' => [
        'title' => 'Correciones',
        'icon' => 'fa fa-edit',
        'route' => 'paal.log.index'
    ],

    // 'clients' => [
    //     'title' => 'Des/Activar',
    //     'icon' => 'fa fa-toggle-on',
    //     'route' => ['paal.variable.edit', 3]
    // ],

    'users' => [
        'title' => 'Usuarios',
        'icon' => 'fa fa-key',
        'route' => 'paal.user.index'
    ],

    // 'reports' => [
    //     'title' => 'Reportes',
    //     'icon' => 'fa fa-bar-chart',
    //     'route' => 'paal.report.index'
    // ],

    'logout' => [
        'title' => 'Salir',
        'icon' => 'fa fa-door-open',
        'route' => 'logout'
    ],
];
