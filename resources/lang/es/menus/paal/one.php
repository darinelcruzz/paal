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
                'route' => ['paal.ingress.daily', ['coffee', 'factura']]
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
            'index' => [
                'title' => 'Historial',
                'route' => ['paal.egress.index', 'pagado']
            ],
            'general' => [
                'title' => 'Generales',
                'route' => 'paal.egress.general.create'
            ],
            'cashier' => [
                'title' => 'Caja Chica',
                'route' => 'paal.egress.register.index'
            ],
            'returns' => [
                'title' => 'Reposiciones',
                'route' => 'paal.egress.return.create'
            ],
            'extra' => [
                'title' => 'Gastos extra',
                'route' => 'paal.egress.return.make'
            ],
        ]
    ],

    'financial-flow' => [
        'title' => 'Flujo financiero',
        'icon' => 'fa fa-wind',
        'route' => 'paal.financial-flow.index'
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
