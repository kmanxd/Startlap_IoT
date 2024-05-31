<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeviceDataResource\Pages;
use App\Filament\Resources\DeviceDataResource\RelationManagers;
use App\Models\DeviceData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeviceDataResource extends Resource
{
    protected static ?string $model = DeviceData::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function getNavigationGroup(): string
    {
        return __('Eszközök');
    }
    public static function getModelLabel(): string
    {
        return __('Eszköz adatok');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Eszköz adatok');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('device_id')->label(__('Eszköz'))
                            ->relationship('device', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('fogyasztas')->label(__('Fogyasztas'))->suffix(__('Wh'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('teljesitmeny')->label(__('Teljesítmény'))->suffix(__('W'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('mukodesiido')->label(__('Működési idő'))->suffix(__('óra'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('device.name')->label(__('Eszköz'))
                ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('fogyasztas')->label(__('Fogyasztás'))->suffix(__('Wh'))
                ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('teljesitmeny')->label(__('Teljesítmény'))->suffix(__('W'))
                ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('mukodesiido')->label(__('Mükődési idő'))->suffix(__('óra'))
                ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label(__('Létrehozva'))
                ->dateTime('Y-m-d H:i')
                ->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeviceData::route('/'),
            'create' => Pages\CreateDeviceData::route('/create'),
            'edit' => Pages\EditDeviceData::route('/{record}/edit'),
        ];
    }
}
