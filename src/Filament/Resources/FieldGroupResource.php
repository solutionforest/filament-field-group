<?php

namespace SolutionForest\FilamentFieldGroup\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Illuminate\Support\Str;
use SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroupResource\Pages;
use SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroupResource\RelationManagers;
use SolutionForest\FilamentFieldGroup\Models\FieldGroup;

class FieldGroupResource extends Resource
{
    protected static ?string $model = FieldGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(function (\Filament\Resources\Pages\Page $livewire) {
                $isEditingLiveiwire = function ($livewire) {
                    if ($livewire instanceof Pages\EditFieldGroup || $livewire instanceof \Filament\Resources\Pages\EditRecord) {
                        return true;
                    }

                    try {
                        $operation = $livewire?->form?->getOperation();
                        if ($operation == 'edit') {
                            return true;
                        }
                    } catch (\Throwable $e) {
                        //
                    }

                    return false;
                };
                $isEditing = $isEditingLiveiwire($livewire);

                $components = [];

                $titleField = Forms\Components\TextInput::make('title')
                    ->label(__('filament-field-group::filament-field-group.title'))
                    ->required()
                    ->maxLength(255)
                    ->live(debounce: 500)
                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('name', Str::slug($state, '_')));
                $nameField = Forms\Components\TextInput::make('name')
                    ->label(__('filament-field-group::filament-field-group.name'))
                    ->hint('e.g. `user_profile`')
                    ->helperText('Unique name for the field group.')
                    ->required()
                    ->maxLength(255)
                    ->live(debounce: 500)
                    ->afterStateUpdated(fn ($component, ?string $state) => $component->state(Str::slug($state, '_')))
                    ->unique(ignoreRecord: true);
                // name field
                if ($isEditing) {
                    $components[] = Forms\Components\Section::make()
                        ->schema([
                            $titleField,
                        ]);
                } else {
                    $components[] = $titleField;
                    $components[] = $nameField;
                }

                // additional fields
                if ($isEditing) {
                    $components[] = Forms\Components\Section::make(__('filament-field-group::filament-field-group.settings'))
                        ->collapsible()->collapsed()
                        ->schema([
                            $nameField,
                            Forms\Components\Toggle::make('active')
                                ->label(__('filament-field-group::filament-field-group.active'))
                                ->inlineLabel()
                                ->default(true),
                        ]);
                }

                return $components;
            });
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->emptyStateHeading(__('filament-field-group::filament-field-group.tables.field-groups.empty-state.heading'))
            ->emptyStateDescription(__('filament-field-group::filament-field-group.tables.field-groups.empty-state.description'))
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->recordTitleAttribute('title')
            ->reorderable('sort')
            ->defaultSort('sort')
            ->modifyQueryUsing(fn ($query) => $query->withCount('fields'))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament-field-group::filament-field-group.name'))
                    ->sortable()->width('1%')
                    ->badge(),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('filament-field-group::filament-field-group.title')),
                Tables\Columns\TextColumn::make('fields_count')
                    ->label(__('filament-field-group::filament-field-group.fields')),
                Tables\Columns\BooleanColumn::make('active')
                    ->label(__('filament-field-group::filament-field-group.active'))
                    ->width('1%'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\FieldsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageFieldGroup::route('/'),
            'edit' => Pages\EditFieldGroup::route('/{record}/edit'),
        ];
    }
}
