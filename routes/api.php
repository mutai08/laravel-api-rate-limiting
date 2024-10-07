<?php

use Illuminate\Support\Facades\Route;

Route::middleware('throttle:10,1')->get('/products', function () {
    return response()->json([
        'products' => [
            ['id' => 1, 'name' => 'Product 1', 'price' => 100],
            ['id' => 2, 'name' => 'Product 2', 'price' => 150],
            ['id' => 3, 'name' => 'Product 3', 'price' => 200],
        ]
    ]);
});