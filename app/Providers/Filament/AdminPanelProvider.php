<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\EditProfile;
use Exception;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Str;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

class AdminPanelProvider extends PanelProvider
{
    /**
     * @throws Exception
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
            ->globalSearch()
            ->userMenuItems([
                'backToWebSite' => MenuItem::make()
                    ->label('Retour au site')
                    ->icon('heroicon-o-home')
                    ->url(config('app.url'), true),
                'profile'       => MenuItem::make()
                    ->label(fn(): string => __('common.profil'))
                    ->url(fn(): string => EditProfile::getUrl())
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([])
            ->pages([])
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
                    ->selectable(!Str::endsWith(request()->url(), '/book'))
                    ->config([
                        'headerToolbar'         => [
                            'left'   => 'prev,next,today',
                            'center' => '',
                            'right'  => 'title',
                        ],
                        'buttonText'            => [
                            'prev'      => '<',
                            'next'      => '>',
                            'today'     => "Aujourd'hui",
                            'month'     => 'mois',
                            'week'      => 'semaine',
                            'day'       => 'jour',
                            'prevYear'  => 'Forrige år',
                            'nextYear'  => 'Neste år',
                            'listMonth' => 'Agenda',
                            'listWeek'  => 'UL',
                        ],
                        'slotLabelFormat'       => [
                            'hour'           => 'numeric',
                            'minute'         => '2-digit',
                            'omitZeroMinute' => false,
                            'meridiem'       => 'short',
                        ],
                        'contentHeight'         => 'auto',
                        'dayMaxEvents'          => true,
                        'weekNumbers'           => true,
                        'weekNumberCalculation' => 'ISO',
                        'weekNumberFormat'      => ['week' => 'numeric'],
                        'nowIndicator'          => true,
                        'droppable'             => true,
                        'displayEventEnd'       => true,
                        'slotDuration'          => '00:15:00',
                        'slotMinTime'           => '08:00:00',
                        'slotMaxTime'           => '18:00:00',
                        'navLinks'              => 'true',
                        'initialView'           => 'timeGridWeek'
                    ])
                    ->plugins(['dayGrid', 'timeGrid', 'rrule', 'interaction', 'list'])
                    ->editable(!Str::endsWith(request()->url(), '/book'))
            );
    }
}
