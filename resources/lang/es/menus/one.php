<?php

return [
    'example1' => [
        'title' => 'Ejemplo 1',
        'icon' => 'fa fa-user',
        'route' => 'home'
    ],

    'example2' => [
        'title' => 'Ejemplo 2',
        'icon' => 'fa fa-plus',
        'submenu' => [
            'submenu1' => [
                'title' => 'Submenu 1',
                'route' => 'home'
            ],
            'submenu2' => [
                'title' => 'Submenu 2',
                'route' => 'home'
            ]
        ]
    ],
];
