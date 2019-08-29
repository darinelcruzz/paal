<?php

return [
    
    'ingresses' => [
        'title' => 'Ingresos',
        'icon' => 'fa fa-truck-loading',
        'submenu' => [
            'index' => [
                'title' => 'Historial',
                'route' => 'mbe.ingress.index'
            ],
            'create' => [
                'title' => 'Agregar',
                'route' => 'mbe.ingress.create'
            ],
        ]
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

    'tasks' => [
        'title' => 'Tareas',
        'icon' => 'fa fa-tasks',
        'route' => 'mbe.task.index'
    ],

    'logout' => [
        'title' => 'Salir',
        'icon' => 'fa fa-door-open',
        'route' => 'logout'
    ],
];
