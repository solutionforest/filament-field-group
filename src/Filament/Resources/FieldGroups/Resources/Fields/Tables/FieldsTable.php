<?php

namespace SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Resources\Fields\Tables;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use SolutionForest\FilamentFieldGroup\Facades\FilamentFieldGroup;

class FieldsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->reorderable('sort')
            ->defaultSort('sort')
            ->columns([
                TextColumn::make('sort')
                    ->label(__('filament-field-group::filament-field-group.sort'))
                    ->sortable()->width('1%'),
                TextColumn::make('id')
                    ->label(__('filament-field-group::filament-field-group.id'))
                    ->sortable()->width('1%'),
                TextColumn::make('label')
                    ->label(__('filament-field-group::filament-field-group.tables.fields.label')),
                TextColumn::make('name')
                    ->label(__('filament-field-group::filament-field-group.tables.fields.name'))
                    ->badge(),
                TextColumn::make('type')
                    ->label(__('filament-field-group::filament-field-group.tables.fields.type'))
                    ->formatStateUsing(fn ($state) => FilamentFieldGroup::getFieldTypeDisplayValue($state))
                    ->icon(function ($state) {
                        $icon = FilamentFieldGroup::getFieldTypeIcon($state);
                        if (! $icon) {
                            return null;
                        }

                        return $icon;
                    }),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }
}
