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

$right_menu = [
    [
        // menu utilizado para views da biblioteca senhaunica-socialite.
        'key' => 'senhaunica-socialite',
    ],
    [
        'key' => 'laravel-tools',
    ],
    [
        'text' => '<i class="fas fa-cog"></i>',
        'title' => 'Configurações',
        'target' => '_blank',
        'url' => config('app.url') . '/config',
        'align' => 'right',
        'can' => 'admin'
    ],
];

$menu = [
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
    ]
];

return [
    # valor default para a tag title, dentro da section title.
    # valor pode ser substituido pela aplicação.
    'title' => config('app.name'),

    # USP_THEME_SKIN deve ser colocado no .env da aplicação
    'skin' => env('USP_THEME_SKIN', 'uspdev'),

    # chave da sessão. Troque em caso de colisão com outra variável de sessão.
    'session_key' => 'laravel-usp-theme',

    # usado na tag base, permite usar caminhos relativos nos menus e demais elementos html
    # na versão 1 era dashboard_url
    'app_url' => config('app.url'),

    # login e logout
    'logout_method' => 'POST',
    'logout_url' => 'logout',
    'login_url' => 'login',

    # menus
    'menu' => $menu,
    'right_menu' => $right_menu,

    # mensagens flash - https://uspdev.github.io/laravel#31-mensagens-flash
    'mensagensFlash' => false,

    # container ou container-fluid
    'container' => 'container-fluid',

];

