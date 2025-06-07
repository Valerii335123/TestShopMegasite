<?php

use App\Livewire\Cart\Cart;
use App\Livewire\Product\Index;
use App\Livewire\Product\Show;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => '/products'], function () {
    Route::get('', Index::class)->name('products.index');
    Route::get('/{product}', Show::class)->name('products.show');
});

Route::get('/cart', Cart::class)->name('cart');