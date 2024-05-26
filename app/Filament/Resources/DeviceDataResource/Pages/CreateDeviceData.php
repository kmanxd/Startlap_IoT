<?php

namespace App\Filament\Resources\DeviceDataResource\Pages;

use App\Filament\Resources\DeviceDataResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDeviceData extends CreateRecord
{
    protected static string $resource = DeviceDataResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
