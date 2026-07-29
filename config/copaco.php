<?php

return [
    'consumer_deploy_key' => env('CONSUMER_DEPLOY_KEY', false),

    'freeradius_habilitar' => env('FREERADIUS_HABILITAR', false),
    'freeradius_host' => env('FREERADIUS_HOST', 'localhost'),
    'freeradius_user' => env('FREERADIUS_USER'),
    'freeradius_db' => env('FREERADIUS_DB'),
    'freeradius_db' => env('FREERADIUS_PASSWD'),
    'freeradius_macaddr_separator' => env('FREERADIUS_MACADDR_SEPARATOR', '-'),
    'freeradius_macaddr_case' => env('FREERADIUS_MACADDR_CASE', 'lower')
];
