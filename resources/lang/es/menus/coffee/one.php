<?php

return [
    'statistics' => [
        'title' => 'Análisis',
        'icon' => 'fas fa-chart-pie',
        'submenu' => [
            'sales' => [
                'title' => 'Ventas',
                'route' => 'coffee.statistics.sales'
            ],
            'shippings' => [
                'title' => 'Envíos',
                'route' => 'coffee.statistics.shippings'
            ],
            'clients' => [
                'title' => 'Clientes',
                'route' => 'coffee.statistics.clients'
            ],
            'places' => [
                'title' => 'Lugares',
                'route' => 'coffee.statistics.places'
            ],
            'monthly' => [
                'title' => 'Corte mensual',
                'route' => 'coffee.admin.monthly'
            ],
        ]
    ],

    'quotations' => [
        'title' => 'Cotizaciones',
        'icon' => 'fas fa-file-invoice',
        'submenu' => [
            'create' => [
                'title' => 'Nueva',
                'route' => 'coffee.quotation.create'
            ],
            // 'make' => [
            //     'title' => 'Proyecto',
            //     'route' => ['coffee.quotation.create', 'proyecto']
            // ],
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
            'invoices' => [
                'title' => 'Facturadas',
                'route' => 'coffee.admin.invoices'
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

    'serial_numbers' => [
        'title' => 'Números de serie',
        'icon' => 'fa fa-barcode',
        'route' => 'coffee.serial_number.index',
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
