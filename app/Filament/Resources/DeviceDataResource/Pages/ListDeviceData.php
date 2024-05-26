<?php

namespace App\Filament\Resources\DeviceDataResource\Pages;

use App\Filament\Resources\DeviceDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeviceData extends ListRecords
{
    protected static string $resource = DeviceDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
