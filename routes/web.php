<?php

use App\Events\OrderPlaced;
use App\Http\Controllers\OrderController;
use App\Http\Livewire\ProductView;
use App\Livewire\CartView;
use App\Livewire\KioskView;
use App\Livewire\OrderShow;
use App\Models\Order;
use App\Models\User;
use App\Notifications\AdminOrderPlaced;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Route;

Route::get('/', KioskView::class)->name('home');
Route::get('/cart', CartView::class)->name('cart');
Route::get('/orders/{orderId}', OrderShow::class)->name('orders.show');
