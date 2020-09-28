<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\RedeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\FreeradiusController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', [IndexController::class, 'index'])->name('home');

# resources
Route::resource('equipamentos', EquipamentoController::class);
Route::resource('redes', RedeController::class);
Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);

# rotas para a senha única
Route::get('/login/usp', [LoginController::class, 'redirectToProvider'])->name('loginusp');
Route::get('/callback', [LoginController::class, 'handleProviderCallback']);

# config
Route::get('/config', [ConfigController::class, 'index']);
Route::post('/config', [ConfigController::class, 'config']);
Route::post('/freeradius/sincronize', [FreeradiusController::class, 'sincronize']);
Route::get('/excel', [EquipamentoController::class, 'excel'])->name('excel');

# Rotas para usuário local, podemos usar Auth::routes() 
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

# logout 
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/logout', [LoginController::class, 'logout']);
