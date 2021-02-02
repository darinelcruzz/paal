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
            'index' => [
                'title' => 'Historial',
                'route' => 'coffee.quotation.index'
            ],
            'campaigns' => [
                'title' => 'Campañas',
                'route' => ['coffee.quotation.internet', 'campañas']
            ],
            'forms' => [
                'title' => 'Formularios',
                'route' => ['coffee.quotation.internet', 'formularios']
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
            'index' => [
                'title' => 'Historial',
                'route' => 'coffee.ingress.index'
            ],
            'invoices' => [
                'title' => 'Facturadas',
                'route' => 'coffee.admin.invoices'
            ],
            'daily' => [
                'title' => 'Corte diario',
                'route' => ['coffee.admin.daily', 'factura']
            ],
            'monthly' => [
                'title' => 'Corte mensual',
                'route' => 'coffee.admin.monthly'
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

    // 'purchases_and_orders' => [
    //     'title' => 'Compras y órdenes',
    //     'icon' => 'fa fa-shopping-cart',
    //     'submenu' => [
    //         'purchases' => [
    //             'title' => 'Compras',
    //             'route' => 'coffee.purchase.index'
    //         ],
    //         'orders' => [
    //             'title' => 'Órdenes',
    //             'route' => 'coffee.order.index'
    //         ],
    //     ]
    // ],

    'egresses' => [
        'title' => 'Egresos',
        'icon' => 'fa fa-share',
        // 'label' => expiringSoonEgresses() > 0 ? expiringSoonEgresses(): '',
        'submenu' => [
            'index' => [
                'title' => 'Historial',
                'route' => ['coffee.egress.index', 'pagado']
            ],
            'general' => [
                'title' => 'Generales',
                'route' => 'coffee.egress.general.create'
            ],
            'cashier' => [
                'title' => 'Caja Chica',
                'route' => 'coffee.egress.register.index'
            ],
            'returns' => [
                'title' => 'Reposiciones',
                'route' => 'coffee.egress.return.create'
            ],
            'extra' => [
                'title' => 'Gastos extra',
                'route' => 'coffee.egress.return.make'
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
