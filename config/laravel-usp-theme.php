<?php

$redes = [
    [
        'text' => 'Cadastrar',
        'url' => config('app.url') . '/redes/create',
    ],
    [
        'text' => 'Listar',
        'url' => config('app.url') . '/redes',
    ],
    [
        'text' => 'Migrar equipamentos entre redes',
        'url' => config('app.url') . '/redes/migrate',
    ],
];

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
            'url'  => config('app.url'),
            'can'  => 'equipamentos.create',
        ],
        [
            'text' => 'Equipamentos',
            'url'  => config('app.url') . '/equipamentos',
            'icon' => 'desktop',
            'can'  => 'equipamentos.create',
        ],
        [
            'text'        => 'Redes',
            'icon'        => 'sitemap',
            'can'         => 'admin',
            'submenu'     => $redes,
        ],
        [
            'text'        => 'Configurações',
            'url'         => config('app.url') . '/config',
            'icon'        => 'file',
            'can'         => 'admin',
        ],
        [
            'text'        => 'Grupos',
            'url'         => config('app.url') . '/roles',
            'icon'        => 'group',
            'can'         => 'admin',
        ], 
        [
            'text'        => 'Pessoas',
            'url'         => config('app.url') . '/users',
            'icon'        => 'home',
            'can'         => 'admin',
        ], 
    ],
];
