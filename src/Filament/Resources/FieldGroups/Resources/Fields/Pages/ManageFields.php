<?php

namespace SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Resources\Fields\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Resources\Fields\FieldResource;

class ManageFields extends ManageRecords
{
    protected static string $resource = FieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
