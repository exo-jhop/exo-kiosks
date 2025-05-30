<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentAsset;
use Filament\Http\Responses\Auth\LoginResponse as FilamentLoginResponse;
use App\Http\Responses\LoginResponse as CustomLoginResponse;
use App\Livewire\OrdersCardView;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        parent::register();

        $this->app->bind(FilamentLoginResponse::class, CustomLoginResponse::class);

        FilamentView::registerRenderHook('panels::head.end', fn() => Blade::render("@vite(['resources/css/app.css'])"));

        FilamentView::registerRenderHook('panels::body.end', fn() => Blade::render("@vite('resources/js/app.js')"));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Livewire::component('orders-card-view', OrdersCardView::class);
    }
}
