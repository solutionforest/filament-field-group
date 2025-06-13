<?php

namespace SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Resources\Fields;

use BackedEnum;
use Filament\Resources\ParentResourceRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\FieldGroupResource;
use SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Resources\Fields\Pages\CreateField;
use SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Resources\Fields\Pages\EditField;
use SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Resources\Fields\Pages\ManageFields;
use SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Resources\Fields\Schemas\FieldForm;
use SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Resources\Fields\Tables\FieldsTable;
use SolutionForest\FilamentFieldGroup\Models\Field;

class FieldResource extends Resource
{
    protected static ?string $model = Field::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return FieldForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FieldsTable::configure($table);
    }

    public static function getParentResourceRegistration(): ?ParentResourceRegistration
    {
        return FieldGroupResource::asParent()
            ->relationship('fields')
            ->inverseRelationship('group');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageFields::route('/'),
            'create' => CreateField::route('/create'),
            'edit' => EditField::route('/{record}/edit'),
        ];
    }
}
