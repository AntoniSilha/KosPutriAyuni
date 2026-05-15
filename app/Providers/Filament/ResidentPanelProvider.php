<?php

namespace App\Providers\Filament;

use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class ResidentPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('resident')
            ->path('dashboard')
            ->brandName('Putri Ayuni')
            ->spa()
            ->sidebarWidth('16rem')
            ->maxContentWidth(Width::Full)
            ->defaultThemeMode(ThemeMode::System)
            ->viteTheme('resources/css/filament/kos-panel.css')
            ->colors([
                'primary' => Color::hex('#766035'),
            ])
            ->defaultAvatarProvider(\App\Filament\AvatarProviders\CustomAvatarProvider::class)
            ->discoverResources(in: app_path('Filament/Resident/Resources'), for: 'App\Filament\Resident\Resources')
            ->discoverPages(in: app_path('Filament/Resident/Pages'), for: 'App\Filament\Resident\Pages')
            ->discoverWidgets(in: app_path('Filament/Resident/Widgets'), for: 'App\Filament\Resident\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
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
            ]);
    }
}
