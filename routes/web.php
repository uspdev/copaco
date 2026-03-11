<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\RedeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\FreeradiusController;
use App\Http\Controllers\FileController;

Route::get('/', [IndexController::class, 'index'])->name('home');

# Migração de equipamentos entre redes
Route::get('redes/migrate', [RedeController::class,'migrate_form']);
Route::post('redes/migrate', [RedeController::class,'migrate_store']);

# resources
Route::resource('equipamentos', EquipamentoController::class);
Route::resource('redes', RedeController::class);
Route::resource('files', FileController::class);

# config
Route::get('/config', [ConfigController::class, 'index']);
Route::post('/config', [ConfigController::class, 'config']);
Route::post('/freeradius/sincronize', [FreeradiusController::class, 'sincronize']);
Route::get('/excel', [EquipamentoController::class, 'excel'])->name('excel');

# Logs  
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('can:admin');
