<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Speciality;
use App\Models\Teacher;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $chartPoints = [17, 5, 10, 3, 15, 4, 17];
        return [
            Stat::make(__('common.users'), User::count())
                ->description(__('common.users'))
                ->descriptionIcon('bi-people-fill')
                ->chart($chartPoints)
                ->color('primary'),

            Stat::make(__('common.teachers'), Teacher::count())
                ->description(__('common.teachers'))
                ->descriptionIcon('heroicon-m-user-group')
                ->chart(array_reverse($chartPoints))
                ->color('success'),

            Stat::make(__('common.categories'), Category::count())
                ->description(__('common.categories'))
                ->descriptionIcon('heroicon-s-tag')
                ->chart($chartPoints)
                ->color('warning'),

            Stat::make(__('common.specialities'), Speciality::count())
                ->description(__('common.specialities'))
                ->descriptionIcon('heroicon-s-star')
                ->chart(array_reverse($chartPoints))
                ->color('danger'),
        ];
    }

    public static function canView(): bool
    {
        return false;
    }
}
