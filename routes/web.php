<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','RedeController@index');
Route::get('/equipamentos/search','EquipamentoController@search');
Route::get('/equipamentos/naoalocados','EquipamentoController@naoAlocados');
Route::resource('equipamentos','EquipamentoController');
Route::resource('redes','RedeController');



# rotas para a senha única
Route::get('/login', 'Auth\LoginController@redirectToProvider');
Route::get('/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('/logout', 'Auth\LoginController@logout');

# APIs
Route::get('/dhcpd.conf','DhcpController@dhcpd');
Route::get('/freeradius/authorize','FreeradiusController@build');

