<?php

namespace SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Resources\Fields\FieldResource;

class FieldsRelationManager extends RelationManager
{
    protected static string $relationship = 'fields';

    protected static ?string $relatedResource = FieldResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()->createAnother(false),
            ]);
    }
}
