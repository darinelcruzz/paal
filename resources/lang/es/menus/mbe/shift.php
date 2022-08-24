<?php

return [
    'ingresses' => [
        'title' => 'MBE',
        'icon' => 'fa fa-truck-loading',
        'submenu' => [
            'create' => [
                'title' => 'Agregar',
                'route' => 'mbe.ingress.create'
            ],
            'shift' => [
                'title' => 'Desfasadas',
                'route' => 'mbe.ingress.shift'
            ],
            'daily' => [
                'title' => 'Corte diario',
                'route' => ['mbe.ingress.daily', 'factura']
            ],
            'invoices' => [
                'title' => 'Facturas',
                'route' => 'mbe.invoice.index'
            ],
            'pending' => [
                'title' => 'Pendientes',
                'route' => 'mbe.invoice.pending'
            ],
            'orders' => [
                'title' => 'Empresariales',
                'route' => 'mbe.order.index'
            ],
            'monthly' => [
                'title' => 'Corte mensual',
                'route' => 'mbe.ingress.monthly'
            ],
            'index' => [
                'title' => 'Historial',
                'route' => 'mbe.ingress.index'
            ],
        ]
    ],

    'clients' => [
        'title' => 'Clientes',
        'icon' => 'fa fa-users',
        'route' => 'mbe.client.index'
    ],

    'tasks' => [
        'title' => 'Tareas',
        'icon' => 'fa fa-tasks',
        'route' => 'mbe.task.index'
    ],

    'logout' => [
        'title' => 'Salir',
        'icon' => 'fa fa-door-open',
        'route' => 'logout'
    ],
];
