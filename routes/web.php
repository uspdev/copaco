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
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

# config
Route::get('/config', 'ConfigController@index');
Route::post('/config', 'ConfigController@config');
Route::post('/freeradius/sincronize', 'FreeradiusController@sincronize');

# APIs
Route::post('/dhcpd.conf', 'DhcpController@dhcpd');
Route::post('/freeradius/authorize-file', 'FreeradiusController@file');

# Rotas para usuário local, podemos usar Auth::routes() 
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
// Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
// Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
// Route::post('password/reset', 'Auth\ResetPasswordController@reset');
