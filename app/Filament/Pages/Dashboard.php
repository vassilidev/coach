<?php

namespace App\Filament\Pages;
use App\Filament\Widgets\StatsOverview;
use Filament\Panel;

class Dashboard extends \Filament\Pages\Dashboard
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->widgets([
                StatsOverview::class
            ]);
    }
}
