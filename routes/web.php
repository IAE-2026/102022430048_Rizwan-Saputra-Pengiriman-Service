<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/api/v1');
});

Route::get('/docs/components', function () {
    return redirect('/api/v1');
});

Route::get('/api/v1/documentation', function () {
    return redirect('/api/v1');
});
