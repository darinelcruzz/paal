<?php

return [

    'admin' => [
        'title' => 'Corte',
        'icon' => 'fa fa-cut',
        'route' => 'coffee.admin.index'
    ],

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
                'title' => 'Diarias',
                'route' => 'coffee.ingress.index'
            ]
            // 'invoices' => [
            //     'title' => 'Facturadas',
            //     'route' => 'coffee.ingress.index'
            // ],
            // 'monthly' => [
            //     'title' => 'Corte mensual',
            //     'route' => 'coffee.ingress.index'
            // ],
            // 'daily' => [
            //     'title' => 'Corte diario',
            //     'route' => 'coffee.ingress.index'
            // ]
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
