<?php

return [

    'admin' => [
        'title' => 'Corte',
        'icon' => 'fa fa-cut',
        'route' => 'coffee.admin.index'
    ],

    'ingresses' => [
        'title' => 'Ventas',
        'icon' => 'fa fa-shopping-cart',
        'route' => 'coffee.ingress.index'
    ],

    'egresses' => [
        'title' => 'Egresos',
        'icon' => 'fa fa-share',
        'route' => 'coffee.egress.index'
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
