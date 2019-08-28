<?php

return [
    
    'ingresses' => [
        'title' => 'Ingresos',
        'icon' => 'fa fa-money',
        'route' => 'mbe.ingress.index'
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
        ]
    ],

    'logout' => [
        'title' => 'Salir',
        'icon' => 'fa fa-door-open',
        'route' => 'logout'
    ],
];
