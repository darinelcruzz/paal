<?php

return [

    'quotations' => [
        'title' => 'Cotizaciones',
        'icon' => 'fas fa-file-invoice',
        'submenu' => [
            'create' => [
                'title' => 'Agregar',
                'route' => 'coffee.quotation.create'
            ],
            'make' => [
                'title' => 'Proyecto',
                'route' => ['coffee.quotation.create', 'proyecto']
            ],
            'index' => [
                'title' => 'Historial',
                'route' => 'coffee.quotation.index'
            ],
            'campaigns' => [
                'title' => 'Campañas',
                'route' => ['coffee.quotation.index', 'campañas']
            ],
            'forms' => [
                'title' => 'Formularios',
                'route' => ['coffee.quotation.index', 'formularios']
            ]
        ]
    ],

    'ingresses' => [
        'title' => 'Ventas',
        'icon' => 'fa fa-mug-hot',
        // 'label' => soldProducts('coffee') > 0 ? soldProducts('coffee'): '',
        'submenu' => [
            'create' => [
                'title' => 'Agregar',
                'route' => 'coffee.ingress.create'
            ],
            'make' => [
                'title' => 'Proyecto',
                'route' => ['coffee.ingress.create', 'proyecto']
            ],
            'index' => [
                'title' => 'Historial',
                'route' => 'coffee.ingress.index'
            ],
            'daily' => [
                'title' => 'Corte diario',
                'route' => ['coffee.admin.daily', 'factura']
            ],
            'invoices' => [
                'title' => 'Facturadas',
                'route' => 'coffee.admin.invoices'
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
