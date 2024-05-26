<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\DeviceType;
use App\Models\Device;

class DeviceTypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('DeviceType', DeviceType::query()->count())->label(__('Eszköz tipusok száma')),
        ];
    }
}
