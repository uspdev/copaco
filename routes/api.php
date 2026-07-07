<?php

use App\Http\Controllers\Api\DhcpController;
use App\Http\Controllers\Api\FreeradiusController;

Route::post('/dhcpd.conf', [DhcpController::class, 'dhcpd']);
Route::post('/uniquedhcpd.conf', [DhcpController::class, 'uniquedhcpd']);
Route::post('/freeradius/authorize_file', [FreeradiusController::class, 'authorize_file']);
