<?php

use App\Http\Controllers\OrderController;
use App\Http\Livewire\ProductView;
use App\Livewire\CartView;
use App\Livewire\KioskView;
use App\Livewire\OrderShow;
use Illuminate\Support\Facades\Route;

Route::get('/', KioskView::class)->name('home');
Route::get('/cart', CartView::class)->name('cart');
Route::get('/orders/{orderId}', OrderShow::class)->name('orders.show');
