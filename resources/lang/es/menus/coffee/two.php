<?php

return [

    'quotations' => [
        'title' => 'Cotizaciones',
        'icon' => 'fas fa-file-invoice',
        'submenu' => [
            'create' => [
                'title' => 'Nueva',
                'route' => 'coffee.quotation.create'
            ],
            'pre' => [
                'title' => 'Abiertas',
                'route' => ['coffee.quotation.index', 'pendiente']
            ],
            'index' => [
                'title' => 'Cerradas',
                'route' => ['coffee.quotation.index', 'terminada']
            ],
            'campaigns' => [
                'title' => 'Campañas',
                'route' => ['coffee.quotation.index', ['terminada', 'campañas']]
            ],
            'forms' => [
                'title' => 'Formularios',
                'route' => ['coffee.quotation.index', ['terminada', 'formularios']]
            ]
        ]
    ],

    'ingresses' => [
        'title' => 'Ventas',
        'icon' => 'fa fa-mug-hot',
        'submenu' => [
            'create' => [
                'title' => 'Agregar',
                'route' => 'coffee.ingress.create'
            ],
            'index' => [
                'title' => 'Historial',
                'route' => 'coffee.ingress.index'
            ],
            'daily' => [
                'title' => 'Corte diario',
                'route' => ['coffee.admin.daily', 'factura']
            ],
            'monthly' => [
                'title' => 'Corte mensual',
                'route' => 'coffee.analysis.index',
            ],
            'logs' => [
                'title' => 'Correciones',
                'route' => 'coffee.log.index'
            ],
            'variables' => [
                'title' => 'Tipo de Cambio',
                'route' => 'coffee.variable.edit'
            ],
        ]
    ],

    'shippings' => [
        'title' => 'Envíos',
        'icon' => 'fa fa-shipping-fast',
        // 'label' => pendingShippings(),
        'submenu' => [
            'create' => [
                'title' => 'Rastreo',
                'route' => ['coffee.shipping.index', 'todos']
            ],
            'index' => [
                'title' => 'Corte',
                'route' => 'coffee.shipping.monthly'
            ],
        ]
    ],

    'tasks' => [
        'title' => 'Tareas',
        'icon' => 'fa fa-tasks',
        'route' => 'coffee.task.index'
    ],

    'products' => [
        'title' => 'Productos',
        'icon' => 'fa fa-tags',
        'route' => 'coffee.product.index'
    ],

    'clients' => [
        'title' => 'Clientes',
        'icon' => 'fa fa-users',
        'route' => 'coffee.client.index'
    ],

    'logout' => [
        'title' => 'Salir',
        'icon' => 'fa fa-door-open',
        'route' => 'logout'
    ],
];
