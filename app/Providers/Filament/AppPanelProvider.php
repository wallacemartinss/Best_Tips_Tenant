<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Register as AuthRegister;
use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use App\Models\Organization;
use Filament\Navigation\MenuItem;
use App\Filament\Pages\Auth\Register;
use Filament\Support\Colors\Color;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Filament\Pages\Tenancy\RegisterOrganization;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
        ->default()
        ->id('app')
        ->path('app')
        ->login()
        ->sidebarFullyCollapsibleOnDesktop()
        ->registration(Register::class)
        ->databaseNotifications()
        ->profile()
        ->userMenuItems([
            MenuItem::make()
                ->label('Admin')
                ->icon('heroicon-o-cog-6-tooth')
                ->url('/admin')
                ->visible(fn (): bool => auth()->user()->is_admin)
        ])
        ->colors([
            'danger' => Color::Red,
            'gray' => Color::Slate,
            'info' => Color::Blue,
            'success' => Color::Emerald,
            'warning' => Color::Orange,
            'primary' => Color::Amber,
        ])
        ->navigationGroups([
            'Configurações',
            'Usúarios e Acessos',
            'Cadastros',
        ])
        ->discoverResources(in: app_path('Filament/App/Resources'), for: 'App\\Filament\\App\\Resources')
        ->discoverPages(in: app_path('Filament/App/Pages'), for: 'App\\Filament\\App\\Pages')
        ->pages([
            Pages\Dashboard::class,
        ])
        ->discoverWidgets(in: app_path('Filament/App/Widgets'), for: 'App\\Filament\\App\\Widgets')
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
        ])
        ->tenant(Organization::class, ownershipRelationship: 'organization', slugAttribute: 'slug')
        ->tenantRegistration(RegisterOrganization::class)
        //->tenantProfile(EditOrganizationProfile::class)
        ->plugins([]);
    }
}
