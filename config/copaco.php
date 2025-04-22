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

    # O auto-cadastro de usuários com login local é permitido via um código de autorização
    #que você deve infomar para as pessoas que poderão fazer esse autocadastro
    'codigo_acesso' => env('CODIGO_ACESSO', false),

    # Se quiser usar apenas senha única e desativar o cadastro de login local
    'somente_senhaunica' => env('SOMENTE_SENHAUNICA', false),
    /*
    |--------------------------------------------------------------------------
    | Senha Única
    |--------------------------------------------------------------------------
    | TODO: DOCUMENTAR VARIÁVEIS
 */

    'senha_unica_key' => env('SENHAUNICA_KEY', false),
    'senha_unica_secret' => env('SENHAUNICA_SECRET', false),
    'senha_unica_callback_id' => env('SENHAUNICA_CALLBACK_ID', false),

    # Sigla das unidades autorizadas, separadas por virgula
    'senha_unica_unidades' => env('SENHAUNICA_UNIDADES'),

    # permitir login de todos, aluno etc
    'allow_login_all' => env('ALLOW_LOGIN_ALL', 0),

    # Admins
    'superadmins_usernames' => env('SUPERADMINS_USERNAMES'),

    /*
    |--------------------------------------------------------------------------
    | DHCP e FreeRadius
    |--------------------------------------------------------------------------
     */

    // consumer_deploy_key = parâmetro enviado para os servidores DHCP e FreeRadius
    'consumer_deploy_key' => env('CONSUMER_DEPLOY_KEY', false),

    // Habilita manipulação direta no BD do freeradius
    'freeradius_habilitar' => env('FREERADIUS_HABILITAR', false),

    // Faz replace de : para o separador informado
    'freeradius_macaddr_separator' => env('FREERADIUS_MACADDR_SEPARATOR', '-'),

    // freeradius_macaddr_case = 'upper','lower'
    'freeradius_macaddr_case' => env('FREERADIUS_MACADDR_CASE', 'lower'),

];
    // 'freeradius_host' => env('FREERADIUS_HOST', 'localhost'),
    // 'freeradius_user' => env('FREERADIUS_USER'),
    // 'freeradius_db' => env('FREERADIUS_DB'),
    // 'freeradius_db' => env('FREERADIUS_PASSWD'),