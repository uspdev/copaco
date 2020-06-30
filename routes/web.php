<?php

Route::get('/', 'IndexController@index')->name('home');

# resources
Route::resource('/equipamentos', 'EquipamentoController');
Route::resource('/redes', 'RedeController');
Route::resource('/roles', 'RoleController');
Route::resource('/users', 'UserController');

# rotas para a senha única
Route::get('/login/usp', 'Auth\LoginController@redirectToProvider')->name('loginusp');
Route::get('/callback', 'Auth\LoginController@handleProviderCallback');

# config
Route::get('/config', 'ConfigController@index');
Route::post('/config', 'ConfigController@config');
Route::post('/freeradius/sincronize', 'FreeradiusController@sincronize');

# Rotas para usuário local, podemos usar Auth::routes() 
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

# logout 
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
