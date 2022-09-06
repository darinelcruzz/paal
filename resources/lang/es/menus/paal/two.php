<?php

return [

    'providers' => [
        'title' => 'Proveedores',
        'icon' => 'fa fa-truck',
        'route' => 'paal.provider.index'
    ],

    'egresses' => [
        'title' => 'Egresos',
        'icon' => 'fa fa-share',
        'route' => ['paal.egress.index', 'coffee']
    ],

    'ingresses' => [
        'title' => 'Ingresos',
        'icon' => 'fa fa-shopping-cart',
        'route' => ['paal.ingress.daily', ['coffee', 'factura']]
    ],

    'logout' => [
        'title' => 'Salir',
        'icon' => 'fa fa-door-open',
        'route' => 'logout'
    ],
];