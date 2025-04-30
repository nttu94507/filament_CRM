<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
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

class ReservePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('reserve')
            ->path('')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->homeUrl('bookings')
            ->discoverResources(in: app_path('Filament/Reserve/Resources'), for: 'App\\Filament\\Reserve\\Resources')
            ->discoverPages(in: app_path('Filament/Reserve/Pages'), for: 'App\\Filament\\Reserve\\Pages')
            ->pages([
//                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Reserve/Widgets'), for: 'App\\Filament\\Reserve\\Widgets')
            ->widgets([

            ])
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Shop')
                    ->icon('heroicon-o-shopping-cart'),
                NavigationGroup::make()
                    ->label('Blog')
                    ->icon('heroicon-o-pencil'),
                NavigationGroup::make()
                    ->label(fn (): string => __('navigation.settings'))
                    ->icon('heroicon-o-cog-6-tooth')
                    ->collapsed(),
            ])
            ->navigationItems([
                NavigationItem::make('建立預約')
                    ->url('/bookings')
                    ->icon('heroicon-o-plus')
                    ->group('預約管理'),
                NavigationItem::make('預約查詢')
                    ->url('/bookings/list') // 注意 panel id 要對
                    ->icon('heroicon-o-calendar-days')
                    ->group('預約管理'),
//

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
            ]);
    }
    public function authMiddleware(): array
    {
        return [];
    }
}
