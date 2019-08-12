<?php

return [

    'quotations' => [
        'title' => 'Cotizaciones',
        'icon' => 'fas fa-file-invoice',
        'submenu' => [
            'create' => [
                'title' => 'Insumos',
                'route' => ['coffee.quotation.create', 'insumos']
            ],
            'create2' => [
                'title' => 'Equipos',
                'route' => ['coffee.quotation.create', 'equipo']
            ],
            'index' => [
                'title' => 'Historial',
                'route' => 'coffee.quotation.index'
            ]
        ]
    ],

    'ingresses' => [
        'title' => 'Ventas',
        'icon' => 'fa fa-mug-hot',
        'submenu' => [
            'create' => [
                'title' => 'Insumos',
                'route' => ['coffee.ingress.create', 'insumos']
            ],
            'create2' => [
                'title' => 'Equipos',
                'route' => ['coffee.ingress.create', 'equipo']
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
                'route' => 'coffee.admin.index'
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
        'label' => pendingShippings(),
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

    'egresses' => [
        'title' => 'Egresos',
        'icon' => 'fa fa-share',
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
