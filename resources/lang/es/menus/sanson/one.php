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
            'index' => [
                'title' => 'Historial',
                'route' => 'sanson.quotation.index'
            ],
            'campaigns' => [
                'title' => 'Campañas',
                'route' => ['sanson.quotation.index', 'campañas']
            ],
            'forms' => [
                'title' => 'Formularios',
                'route' => ['sanson.quotation.index', 'formularios']
            ]

        ]
    ],

    'ingresses' => [
        'title' => 'Ventas',
        'icon' => 'fa fa-mug-hot',
        // 'label' => soldProducts('sanson') > 0 ? soldProducts('sanson'): '',
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
        // 'label' => pendingShippings('sanson') > 0 ? pendingShippings('sanson'): '',
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

    'purchases_and_orders' => [
        'title' => 'Órdenes y compras',
        'icon' => 'fa fa-shopping-cart',
        'submenu' => [
            'orders' => [
                'title' => 'Órdenes',
                'route' => 'sanson.order.index'
            ],
            'purchases' => [
                'title' => 'Compras',
                'route' => 'sanson.purchase.index'
            ],
        ]
    ],

    'egresses' => [
        'title' => 'Egresos',
        'icon' => 'fa fa-share',
        'submenu' => [
            'index' => [
                'title' => 'Historial',
                'route' => ['sanson.egress.index', 'pagado']
            ],
            'general' => [
                'title' => 'Generales',
                'route' => 'sanson.egress.general.create'
            ],
            'cashier' => [
                'title' => 'Caja Chica',
                'route' => 'sanson.egress.register.index'
            ],
            'returns' => [
                'title' => 'Reposiciones',
                'route' => 'sanson.egress.return.create'
            ],
            'extra' => [
                'title' => 'Gastos extra',
                'route' => 'sanson.egress.return.make'
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
        'route' => 'sanson.serial_number.index',
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
