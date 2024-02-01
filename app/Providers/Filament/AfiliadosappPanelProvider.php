<?php

namespace App\Providers\Filament;

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

class AfiliadosappPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('afiliadosapp')
            ->path('afiliadosapp')
            ->login()
            ->registration()
            ->profile()
            ->authGuard('affiliate')
            ->colors([
                'gray' => Color::Sky,
                'primary' => Color::Cyan,
            ])
            ->font('Gotham')
            ->brandName('Shopcard')
            ->brandLogo(asset('images/logoshopcard1.jpg'))
            ->darkModeBrandLogo(asset('images/logoshopcard2.png'))
            ->brandLogoHeight('4rem')
            ->favicon(asset('images/favicon.png'))
            ->discoverResources(in: app_path('Filament/Afiliadosapp/Resources'), for: 'App\\Filament\\Afiliadosapp\\Resources')
            ->discoverPages(in: app_path('Filament/Afiliadosapp/Pages'), for: 'App\\Filament\\Afiliadosapp\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Afiliadosapp/Widgets'), for: 'App\\Filament\\Afiliadosapp\\Widgets')
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
            ])->sidebarCollapsibleOnDesktop()->topNavigation();
    }
}
