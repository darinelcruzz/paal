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
            ]
        ]
    ],

    'shippings' => [
        'title' => 'Envíos',
        'icon' => 'fa fa-shipping-fast',
        'route' => 'coffee.shipping.index'
    ],

    'variables' => [
        'title' => 'TC',
        'icon' => 'fa fa-dollar',
        'route' => 'coffee.variable.edit'
    ],

    'egresses' => [
        'title' => 'Egresos',
        'icon' => 'fa fa-share',
        'submenu' => [
            'create' => [
                'title' => 'Agregar',
                'route' => 'coffee.egress.create'
            ],
            'index' => [
                'title' => 'Historial',
                'route' => 'coffee.egress.index'
            ],
        ]
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
