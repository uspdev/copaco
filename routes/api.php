<?php

use Illuminate\Http\Request;

Route::post('/dhcpd.conf', 'Api\DhcpController@dhcpd');
Route::post('/uniquedhcpd.conf', 'Api\DhcpController@uniquedhcpd');
Route::post('/freeradius/authorize_file', 'Api\FreeradiusController@authorize_file');

Route::post('/equipamentos/{patrimonio}/ip', 'Api\EquipamentoController@ip');
