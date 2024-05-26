<?php

namespace App\Filament\Resources\DeviceTypeResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\DeviceResource;

class DevicesRelationManager extends RelationManager
{
    protected static string $relationship = 'devices';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Eszközök');
    }

    public static function getModelLabel(): string
    {
        return __('eszköz létrehozása');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('id')->label(__('Azonosító'))
                ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')
                ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('type.name')->label(__('Típus'))
                ->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->url(fn(): string => DeviceResource::getUrl('create')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->url(fn(Model $record): string => DeviceResource::getUrl('view', ['record' => $record])),
                Tables\Actions\EditAction::make()->url(fn(Model $record): string => DeviceResource::getUrl('edit', ['record' => $record])),
            ])
            ->bulkActions([])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()->url(fn(): string => DeviceResource::getUrl('create')),
            ]);
    }
}
