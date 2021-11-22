<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'success' => true,
        'message' => 'Sucesso ao retornar'
    ]);
});

Route::apiResource('categories', \App\Http\Controllers\Api\CategoryController::class);
