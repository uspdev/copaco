<?php

return [
    'title' => '',
    'skin' => env('USP_THEME_SKIN', 'uspdev'),
    'app_url' => config('app.url'),
    'logout_method' => 'POST',
    'logout_url' => config('app.url') . '/logout',
    'login_url' => config('app.url') . '/login',

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
