<?php

use App\Http\Controllers\Api\DhcpController;
use App\Http\Controllers\Api\FreeradiusController;
use App\Http\Controllers\Api\EquipamentoController;
use App\Http\Controllers\Api\KeaController;

Route::post('/dhcpd.conf', [DhcpController::class, 'dhcpd']);
Route::post('/uniquedhcpd.conf', [DhcpController::class, 'uniquedhcpd']);
Route::post('/freeradius/authorize_file', [FreeradiusController::class, 'authorize_file']);
Route::post('/kea', [KeaController::class, 'kea']);
Route::post('/kea/unique', [KeaController::class, 'uniquekeab']);