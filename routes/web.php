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
Route::resource('equipamentos','EquipamentoController');
Route::resource('redes','RedeController');
Route::get('/dhcpd.conf','DhcpController@dhcpd');