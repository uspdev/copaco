<?php

return [
    'title'=> env('APP_NAME'),
    'dashboard_url' => '/',
    'logout_method' => 'POST',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'menu' => [
        [
            'text' => 'Minha Conta',
            'url'  => '/',
            'can'  => 'equipamentos.create',
        ],
        [
            'text' => 'Equipamentos',
            'url'  => '/equipamentos',
            'icon' => 'desktop',
            'can'  => 'equipamentos.create',
        ],
        [
            'text'        => 'Redes',
            'url'         => '/redes',
            'icon'        => 'sitemap',
            'can'         => 'admin',
        ],
        [
            'text'        => 'Configurações',
            'url'         => '/config',
            'icon'        => 'file',
            'can'         => 'admin',
        ],
        [
            'text'        => 'Grupos',
            'url'         => '/roles',
            'icon'        => 'group',
            'can'         => 'admin',
        ], 
        [
            'text'        => 'Pessoas',
            'url'         => '/users',
            'icon'        => 'home',
            'can'         => 'admin',
        ], 
    ],
];
