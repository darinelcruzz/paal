<?php

return [
    
    'ingresses' => [
        'title' => 'Ingresos',
        'icon' => 'fa fa-truck-loading',
        'submenu' => [
            'create' => [
                'title' => 'Agregar',
                'route' => 'mbe.ingress.create'
            ],
            'daily' => [
                'title' => 'Corte diario',
                'route' => ['mbe.ingress.daily', 'factura']
            ],
            'invoices' => [
                'title' => 'Facturas',
                'route' => 'mbe.invoice.index'
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
    
    'egresses' => [
        'title' => 'Egresos',
        'icon' => 'fa fa-share',
        'submenu' => [
            'index' => [
                'title' => 'Historial',
                'route' => ['mbe.egress.index', 'pagado']
            ],
            'general' => [
                'title' => 'Generales',
                'route' => 'mbe.egress.general.create'
            ],
            'cashier' => [
                'title' => 'Caja Chica',
                'route' => 'mbe.egress.register.index'
            ],
            'returns' => [
                'title' => 'Reposiciones',
                'route' => 'mbe.egress.return.create'
            ],
            'extra' => [
                'title' => 'Gastos extra',
                'route' => 'mbe.egress.return.make'
            ],
        ]
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
