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
                'route' => 'paal.financial-flow.iva',
            ],
            'subtotal' => [
                'title' => 'Subtotal',
                'route' => 'paal.financial-flow.subtotal',
            ]
        ]
    ],

    'tasks' => [
        'title' => 'Tareas',
        'icon' => 'fa fa-tasks',
        'route' => 'paal.task.index'
    ],

    'logs' => [
        'title' => 'Correciones',
        'icon' => 'fa fa-edit',
        'route' => 'paal.log.index'
    ],

    'users' => [
        'title' => 'Usuarios',
        'icon' => 'fa fa-key',
        'route' => 'paal.user.index'
    ],

    'logout' => [
        'title' => 'Salir',
        'icon' => 'fa fa-door-open',
        'route' => 'logout'
    ],
];
