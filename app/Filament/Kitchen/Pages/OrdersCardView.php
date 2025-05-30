<?php

namespace App\Filament\Kitchen\Pages;

use Filament\Pages\Page;

class OrdersCardView extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static string $view = 'filament.kitchen.pages.orders-card-view';

    public static function getSlug(): string
    {
        return 'orders-card-view';
    }
}
