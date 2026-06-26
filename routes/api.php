<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\InboundShipmentController;
use App\Http\Middleware\CheckIaeKey;

Route::middleware([CheckIaeKey::class])->group(function () {
    Route::get('/v1/inbound-shipments', [InboundShipmentController::class, 'index']);
    Route::get('/v1/inbound-shipments/{id}', [InboundShipmentController::class, 'show']);
    Route::post('/v1/inbound-shipments', [InboundShipmentController::class, 'store']);
});