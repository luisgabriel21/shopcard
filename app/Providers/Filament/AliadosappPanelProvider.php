<?php

namespace App\Providers\Filament;

use App\Filament\Aliadosapp\Resources\AppointmentResource\Widgets\AppointmenStatusOverview;
use Filament\Http\Middleware\Authenticate;
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
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AliadosappPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('aliadosapp')
            ->path('aliadosapp')
            ->login()
            ->profile()
            ->authGuard('partner')
            ->colors([
                'gray' => Color::Sky,
                'primary' => Color::Zinc,
            ])
            ->font('Gotham')
            ->brandName('Shopcard')
            ->brandLogo(asset('images/logoshopcard1.jpg'))
            ->darkModeBrandLogo(asset('images/logoshopcard2.png'))
            ->brandLogoHeight('4rem')
            ->favicon(asset('images/favicon.png'))
            ->discoverResources(in: app_path('Filament/Aliadosapp/Resources'), for: 'App\\Filament\\Aliadosapp\\Resources')
            ->discoverPages(in: app_path('Filament/Aliadosapp/Pages'), for: 'App\\Filament\\Aliadosapp\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Aliadosapp/Widgets'), for: 'App\\Filament\\Aliadosapp\\Widgets')
            ->widgets([

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
            ])->databaseNotifications()->databaseNotificationsPolling(interval:'2s')
            ->sidebarCollapsibleOnDesktop()->topNavigation();
    }
}
