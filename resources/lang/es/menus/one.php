<?php

return [
    'example1' => [
        'title' => 'Ejemplo',
        'icon' => 'fa fa-user',
        'route' => 'home'
    ],

    'providers' => [
        'title' => 'Proveedores',
        'icon' => 'fa fa-truck',
        'submenu' => [
            'submenu1' => [
                'title' => 'Lista',
                'route' => 'provider.index'
            ],
            'submenu2' => [
                'title' => 'Agregar',
                'route' => 'provider.create'
            ]
        ]
    ],

    'egresses' => [
        'title' => 'Egresos',
        'icon' => 'fa fa-share',
        'submenu' => [
            'submenu1' => [
                'title' => 'Lista',
                'route' => 'egress.index'
            ],
            'submenu2' => [
                'title' => 'Agregar',
                'route' => 'egress.create'
            ]
        ]
    ],
];
