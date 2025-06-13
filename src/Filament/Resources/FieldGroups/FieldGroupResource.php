<?php

namespace SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Pages\EditFieldGroup;
use SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Pages\ManageFieldGroups;
use SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\RelationManagers\FieldsRelationManager;
use SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Schemas\FieldGroupForm;
use SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Tables\FieldGroupsTable;
use SolutionForest\FilamentFieldGroup\Models\FieldGroup;

class FieldGroupResource extends Resource
{
    protected static ?string $model = FieldGroup::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedSquares2x2;

    public static function form(Schema $schema): Schema
    {
        return FieldGroupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FieldGroupsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            FieldsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageFieldGroups::route('/'),
            'edit' => EditFieldGroup::route('/{record}/edit'),
        ];
    }
}
