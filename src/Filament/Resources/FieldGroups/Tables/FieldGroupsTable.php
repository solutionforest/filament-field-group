<?php

namespace SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FieldGroupsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->emptyStateHeading(__('filament-field-group::filament-field-group.tables.field-groups.empty-state.heading'))
            ->emptyStateDescription(__('filament-field-group::filament-field-group.tables.field-groups.empty-state.description'))
            ->emptyStateActions([
                CreateAction::make(),
            ])
            ->recordTitleAttribute('title')
            ->reorderable('sort')
            ->defaultSort('sort')
            ->modifyQueryUsing(fn ($query) => $query->withCount('fields'))
            ->columns([
                TextColumn::make('name')
                    ->label(__('filament-field-group::filament-field-group.name'))
                    ->sortable()->width('1%')
                    ->badge(),
                TextColumn::make('title')
                    ->label(__('filament-field-group::filament-field-group.title')),
                TextColumn::make('fields_count')
                    ->label(__('filament-field-group::filament-field-group.fields')),
                IconColumn::make('active')
                    ->label(__('filament-field-group::filament-field-group.active'))
                    ->boolean()
                    ->width('1%'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
