<?php

namespace App\Filament\Resources;

use App\Enums\WorksheetPriority;
use App\Filament\Resources\WorksheetResource\Pages;
use App\Filament\Resources\WorksheetResource\RelationManagers;
use App\Models\User;
use App\Models\Worksheet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WorksheetResource extends Resource
{
    protected static ?string $model = Worksheet::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-plus';

    public static function getNavigationGroup(): string
    {
        return __('Hibajelentések');
    }

    protected static ?int $navigationSort = 7;

    public static function getModelLabel(): string
    {
        return __('Munkalapok');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Munkalapok');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\Select::make('device_id')->label(__('Eszköz neve'))
                        ->relationship('device', 'name')
                        ->required(),
                    Forms\Components\Select::make('creator_id')->label(__('Bejelentő'))
                        ->relationship('creator', 'name')
                        ->default(!auth()->user()->can('update worksheets') ? auth()->user()->id : null)
                        ->disabled(!auth()->user()->can('update worksheets') ? true : false)
                        ->required(),
                    Forms\Components\Select::make('repairer_id')->label(__('Karbantartó'))
                        ->options(User::role('repairer')->get()->pluck('name', 'id'))
                        ->disabled(!auth()->user()->can('update worksheets')),
                    Forms\Components\Select::make('priority')->label(__('Prioritás'))
                        ->options(WorksheetPriority::class)
                        ->default('Normal')
                        ->required(),
                    Forms\Components\Textarea::make('description')->label(__('Leírás'))
                        ->required()
                        ->maxLength(65535)
                        ->columnSpanFull(),
                    Forms\Components\DatePicker::make('due_date')->label(__('Esedékes'))
                        ->hidden(!auth()->user()->can('update worksheets'))
                        ->minDate(now()),
                    Forms\Components\DatePicker::make('finish_date')->label(__('Befejezve'))
                        ->disabled(!auth()->user()->can('update worksheets'))
                        ->minDate(now())
                        ->default(now()),
                    Forms\Components\FileUpload::make('attachments')->label(__('Mellékletek'))
                        ->required()
                        ->image()
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            null,
                            '16:9',
                            '4:3',
                            '1:1',
                        ])
                        ->imageEditorEmptyFillColor('#000000')
                        ->imageEditorViewportWidth('1920')
                        ->imageEditorViewportHeight('1080')
                        ->multiple()
                        ->preserveFilenames()
                        ->openable()
                        ->downloadable()
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('comment')->label(__('Megjegyzés'))
                        ->maxLength(65535)
                        ->columnSpanFull(),
                ])
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label(__('Létrehozva'))
                    ->dateTime('Y-m-d H:i')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('device.name')->label(__('Eszköz neve'))
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')->label(__('Leírás'))
                    ->limit(30)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('priority')->label(__('Prioritás'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('creator.name')->label(__('Bejelentő'))
                    ->numeric()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('repairer.name')->label(__('Karbantartó'))
                    ->numeric()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('due_date')->label(__('Esedékes'))
                    ->date('Y-m-d')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('finish_date')->label(__('Befejezve'))
                    ->date('Y-m-d')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->label(__('Frissítve'))
                    ->dateTime('Y-m-d H:i')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListWorksheets::route('/'),
            'create' => Pages\CreateWorksheet::route('/create'),
            'view' => Pages\ViewWorksheet::route('/{record}'),
            'edit' => Pages\EditWorksheet::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if (!auth()->user()->can('update worksheets')) {
            return parent::getEloquentQuery()->where('creator_id', auth()->user()->id);
        }
        return parent::getEloquentQuery();
    }
}