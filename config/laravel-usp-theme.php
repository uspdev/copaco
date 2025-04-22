<?php

$redes = [
    [
        'text' => 'Cadastrar',
        'url'  => 'redes/create',
    ],
    [
        'text' => 'Listar',
        'url'  => 'redes',
    ],
    [
        'text' => 'Migrar equipamentos entre redes',
        'url'  => 'redes/migrate',
    ],
];

$menu = [
    [
        'text' => 'Minha Conta',
        'url'  => '',
        'can'  => 'equipamentos.create',
    ],
    [
        'text' => 'Equipamentos',
        'url'  => 'equipamentos',
        'icon' => 'desktop',
        'can'  => 'equipamentos.create',
    ],
    [
        'text'    => 'Redes',
        'icon'    => 'sitemap',
        'can'     => 'admin',
        'submenu' => $redes,
    ],
    [
        'text' => 'Configurações',
        'url'  => 'config',
        'icon' => 'file',
        'can'  => 'admin',
    ],
    [
        'text' => 'Grupos',
        'url'  => 'roles',
        'icon' => 'group',
        'can'  => 'admin',
    ],
    [
        'text' => 'Pessoas',
        'url'  => 'users',
        'icon' => 'home',
        'can'  => 'admin',
    ],
];

$right_menu = [
    // [
    //     'key' => 'senhaunica-socialite'
    // ],
    [
        'text'   => '<i class="fas fa-hard-hat"></i>',
        'title'  => 'logs',
        'target' => '_blank',
        'url'    => 'logs',
        'align'  => 'right',
        'can'    => 'admin',
    ],
];

return [
    # valor default para a tag title, dentro da section title.
    # valor pode ser substituido pela aplicação.
    'title'          => '', //config('app.name'),

    # USP_THEME_SKIN deve ser colocado no .env da aplicação
    'skin'           => env('USP_THEME_SKIN', 'uspdev'),

    # chave da sessão. Troque em caso de colisão com outra variável de sessão.
    'session_key'    => 'laravel-usp-theme',

    # usado na tag base, permite usar caminhos relativos nos menus e demais elementos html
    # na versão 1 era dashboard_url
    'app_url'        => config('app.url'),

    # login e logout
    'logout_method'  => 'POST',
    'logout_url'     => 'logout',
    'login_url'      => 'login',

    # menus
    'menu'           => $menu,
    'right_menu'     => $right_menu,

    # mensagens flash - https://uspdev.github.io/laravel#31-mensagens-flash
    'mensagensFlash' => true,

    # container ou container-fluid
    'container'      => 'container-fluid',

];
