<?php

return [
    'example1' => [
        'title' => 'Ejemplo',
        'icon' => 'fa fa-user',
        'route' => 'coffee.index'
    ],

    'providers' => [
        'title' => 'Proveedores',
        'icon' => 'fa fa-truck',
        'submenu' => [
            'submenu1' => [
                'title' => 'Lista',
                'route' => 'coffee.provider.index'
            ],
            'submenu2' => [
                'title' => 'Agregar',
                'route' => 'coffee.provider.create'
            ]
        ]
    ],

    'egresses' => [
        'title' => 'Egresos',
        'icon' => 'fa fa-share',
        'submenu' => [
            'submenu1' => [
                'title' => 'Lista',
                'route' => 'coffee.egress.index'
            ],
            'submenu2' => [
                'title' => 'Agregar',
                'route' => 'coffee.egress.create'
            ]
        ]
    ],

    'paal' => [
        'title' => 'PAAL',
        'icon' => 'fa fa-folder-open',
        'route' => 'paal.index'
    ],

    'mbe' => [
        'title' => 'MBE',
        'icon' => 'fa fa-envelope-o',
        'route' => 'mbe.index'
    ],

    'logout' => [
        'title' => 'Salir',
        'icon' => 'fa fa-sign-out',
        'route' => 'logout'
    ],
];
