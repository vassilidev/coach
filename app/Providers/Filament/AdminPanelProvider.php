<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
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
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

class AdminPanelProvider extends PanelProvider
{
    /**
     * @throws \Exception
     */
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('dashboard')
            ->login(Login::class)
            ->colors([
                'primary' => Color::Blue,
            ])
            ->registration()
            ->passwordReset()
            ->profile()
            ->globalSearch()
            ->userMenuItems([
                'backToWebSite' => MenuItem::make()
                    ->label('Retour au site')
                    ->icon('heroicon-o-home')
                    ->url(config('app.url'), true),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
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
            ->plugin(
                FilamentFullCalendarPlugin::make()
                    ->selectable()
                    ->config([
                        'headerToolbar' => [
                            'left' => 'prev,next,today',
                            'center' => 'title',
                            'right' => 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
                        ],
                        'buttonText' => [
                            'prev' => '<',
                            'next' => '>',
                            'today' => 'today',
                            'month' => 'month',
                            'week' => 'week',
                            'day' => 'day',
                            'prevYear' => 'Forrige år',
                            'nextYear' => 'Neste år',
                            'listMonth' => 'Agenda',
                            'listWeek' => 'UL',
                        ],
                        'slotLabelFormat' => [
                            'hour' => 'numeric',
                            'minute' => '2-digit',
                            'omitZeroMinute' => false,
                            'meridiem' => 'short',
                        ],
                        'contentHeight' => 'auto',
                        'dayMaxEvents' => true,
                        'weekNumbers' => true,
                        'weekNumberCalculation' => 'ISO',
                        'weekNumberFormat' => ['week' => 'numeric'],
                        'nowIndicator' => true,
                        'droppable' => true,
                        'displayEventEnd' => true,
                        'slotDuration' => '00:15:00',
                        'slotMinTime' => '08:00:00',
                        'slotMaxTime' => '23:00:00',
                        'navLinks' => 'true'

                    ])
                    ->plugins(['dayGrid', 'timeGrid', 'rrule', 'interaction', 'list'], true)
                    ->editable()
            );
    }
}
