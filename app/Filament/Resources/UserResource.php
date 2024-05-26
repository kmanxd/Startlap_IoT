<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\CreateUser;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getNavigationGroup(): string
    {
        return __('Adminisztráció');
    }

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return __('Felhasználók');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Felhasználók');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')->label(__('Név'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->maxLength(255)
                            ->required(static fn(Page $livewire): string => $livewire instanceof CreateUser, )
                            ->dehydrateStateUsing(
                                fn(?string $state): ?string =>
                                filled($state) ? Hash::make($state) : null
                            )
                            ->dehydrated(
                                fn(?string $state): bool =>
                                filled($state)
                            )
                            ->label(
                                fn(Page $livewire): string => ($livewire instanceof EditUser) ? __('Új jelszó') : __('Jelszó')
                            ),
                        Forms\Components\CheckboxList::make('roles')->label(__('Szerepkör'))
                            ->columnSpanFull()
                            ->relationship('roles', 'name')
                            ->columns(3)
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('Név'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')->label(__('Email'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')->label(__('Szerepkör'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label(__('Létrehozva'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')->label(__('Törölve'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
