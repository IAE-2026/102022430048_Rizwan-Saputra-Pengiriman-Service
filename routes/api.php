<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\InboundShipmentController;
use App\Http\Middleware\CheckIaeKey;

Route::prefix('v1')->middleware([CheckIaeKey::class])->group(function () {
    Route::get('/inbound-shipments', [InboundShipmentController::class, 'index']);
    Route::get('/inbound-shipments/{id}', [InboundShipmentController::class, 'show']);
    Route::post('/inbound-shipments', [InboundShipmentController::class, 'store']);
});