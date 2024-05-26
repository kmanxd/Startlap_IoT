<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Device;
use App\Models\DeviceType;

class DeviceOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Device', Device::query()->count())->label(__('Eszközök száma')),
        ];
    }
}
