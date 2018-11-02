<?php

return [
    /*
    |--------------------------------------------------------------------------
    | USPdev Copaco - Arquivo Principal de Configuração
    |--------------------------------------------------------------------------
    |
    | Este arquivo abriga as integrações com bibliotecas desenvolvidas pelo USPdev e bibliotecas
    | externas. Novas diretivas devem ser criadas aqui se a release do desenvolvedor
    | não provê um arquivo próprio de configuração
    |
 */

    /*
    |--------------------------------------------------------------------------
    | Senha Única
    |--------------------------------------------------------------------------
    | TODO: DOCUMENTAR VARIÁVEIS
 */

    'senha_unica_key' => env('SENHAUNICA_KEY', false),
    'senha_unica_secret' => env('SENHAUNICA_SECRET', false),
    'senha_unica_callback_id' => env('SENHAUNICA_CALLBACK_ID', false),

    # Ambiente de desenvolvimento
    'senha_unica_override' => env('SENHAUNICA_OVERRIDE', false),
    'developer_id' => env('DEVELOPER_ID'),

    # Admins
    'superadmins_ids' => env('SUPERADMINS_IDS'),
    'super_admins_senha_unica' => env('SUPERADMINS_SENHAUNICA'),
    'super_admins_ldap' => env('SUPERADMINS_LDAP'),
    /*
    |--------------------------------------------------------------------------
    | DHCP e FreeRadius
    |--------------------------------------------------------------------------
    | consumer_deploy_key = parâmetro enviado para os servidores DHCP e FreeRadius
    | freeradius_macaddr_case = 'upper','lower'
     */
    'consumer_deploy_key' => env('CONSUMER_DEPLOY_KEY', false),

    'freeradius_habilitar' => env('FREERADIUS_HABILITAR', false),
    'freeradius_host' => env('FREERADIUS_HOST', 'localhost'),
    'freeradius_user' => env('FREERADIUS_USER'),
    'freeradius_db' => env('FREERADIUS_DB'),
    'freeradius_db' => env('FREERADIUS_PASSWD'),
    'freeradius_macaddr_separator' => env('FREERADIUS_MACADDR_SEPARATOR', '-'),
    'freeradius_macaddr_case' => env('FREERADIUS_MACADDR_CASE', 'lower')
];