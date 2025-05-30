<?php

namespace App\Providers\Filament;

use App\Http\Middleware\RedirectIfNotAuthorized;
use App\Http\Responses\LoginResponse;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Facades\Auth;

class KitchenPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('kitchen')
            ->path('kitchen')
            // ->login()
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->authGuard('web')
            ->topNavigation()
            ->brandName('Exo Kitchen')
            ->discoverResources(in: app_path('Filament/Kitchen/Resources'), for: 'App\\Filament\\Kitchen\\Resources')
            ->discoverPages(in: app_path('Filament/Kitchen/Pages'), for: 'App\\Filament\\Kitchen\\Pages')
            ->pages([
                Pages\Dashboard::class,
                \App\Filament\Kitchen\Pages\OrdersCardView::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Kitchen/Widgets'), for: 'App\\Filament\\Kitchen\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                'web',
                RedirectIfNotAuthorized::class,
            ]);
    }
}
