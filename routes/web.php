<?php

use App\Http\Livewire\ProductView;
use App\Livewire\CartView;
use App\Livewire\KioskView;
use Illuminate\Support\Facades\Route;

Route::get('/', KioskView::class)->name('home');
Route::get('/cart', CartView::class)->name('cart');
