<?php

return [

    'quotations' => [
        'title' => 'Cotizaciones',
        'icon' => 'fas fa-file-invoice',
        'submenu' => [
            'create' => [
                'title' => 'Equipos y refacciones',
                'route' => ['sanson.quotation.create', 'equipo']
            ],
            'make' => [
                'title' => 'Proyectos',
                'route' => ['sanson.quotation.create', 'proyecto']
            ],
            'internet' => [
                'title' => 'Internet',
                'route' => 'sanson.quotation.internet'
            ],
            'index' => [
                'title' => 'Historial',
                'route' => 'sanson.quotation.index'
            ]
        ]
    ],

    'ingresses' => [
        'title' => 'Ventas',
        'icon' => 'fa fa-mug-hot',
        'submenu' => [
            'create' => [
                'title' => 'Equipos y refacciones',
                'route' => ['sanson.ingress.create', 'equipo']
            ],
            'create2' => [
                'title' => 'Proyectos',
                'route' => ['sanson.ingress.create', 'proyecto']
            ],
            'index' => [
                'title' => 'Historial',
                'route' => 'sanson.ingress.index'
            ],
            'invoices' => [
                'title' => 'Facturadas',
                'route' => 'sanson.admin.invoices'
            ],
            'daily' => [
                'title' => 'Corte diario',
                'route' => ['sanson.admin.daily', 'factura']
            ],
            'monthly' => [
                'title' => 'Corte mensual',
                'route' => 'sanson.admin.monthly'
            ],
            'variables' => [
                'title' => 'Tipo de Cambio',
                'route' => 'sanson.variable.edit'
            ],
        ]
    ],

    'shippings' => [
        'title' => 'Envíos',
        'icon' => 'fa fa-shipping-fast',
        'label' => pendingShippings('sanson'),
        'submenu' => [
            'create' => [
                'title' => 'Rastreo',
                'route' => ['sanson.shipping.index', 'todos']
            ],
            'index' => [
                'title' => 'Corte',
                'route' => 'sanson.shipping.monthly'
            ],
        ]
    ],

    'tasks' => [
        'title' => 'Tareas',
        'icon' => 'fa fa-tasks',
        'route' => 'sanson.task.index'
    ],

    'products' => [
        'title' => 'Productos',
        'icon' => 'fa fa-tags',
        'route' => 'sanson.product.index'
    ],

    'serial_numbers' => [
        'title' => 'Números de serie',
        'icon' => 'fa fa-barcode',
        'route' => 'sanson.serial_number.index'
    ],

    'clients' => [
        'title' => 'Clientes',
        'icon' => 'fa fa-users',
        'route' => 'sanson.client.index'
    ],

    'logout' => [
        'title' => 'Salir',
        'icon' => 'fa fa-door-open',
        'route' => 'logout'
    ],
];
