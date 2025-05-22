<?php

use App\Http\Livewire\ProductView;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/kiosks', function () {
    return view('livewire.kiosk-view');
});
