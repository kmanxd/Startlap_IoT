<?php

namespace App\Filament\Resources\DeviceDataResource\Pages;

use App\Filament\Resources\DeviceDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeviceData extends EditRecord
{
    protected static string $resource = DeviceDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
