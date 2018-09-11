<?php

Route::get('/', 'IndexController@index');

# resources
Route::resource('equipamentos', 'EquipamentoController');
Route::resource('redes', 'RedeController');

# rotas para a senha única
Route::get('/login', 'Auth\LoginController@redirectToProvider')->name('login');
Route::get('/callback', 'Auth\LoginController@handleProviderCallback');
Route::post('/logout', 'Auth\LoginController@logout');

# APIs
Route::get('/dhcpd.conf', 'DhcpController@dhcpd');
Route::get('/freeradius/authorize', 'FreeradiusController@build');
Route::get('/freeradius/sincronize', 'FreeradiusController@sincronize');

# outros
Route::post('/equipamentos/search', 'EquipamentoController@search');
Route::get('/equipamentos/naoalocados', 'EquipamentoController@naoAlocados');
