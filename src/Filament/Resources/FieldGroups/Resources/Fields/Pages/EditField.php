<?php

namespace SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Resources\Fields\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Resources\Fields\FieldResource;

class EditField extends EditRecord
{
    protected static string $resource = FieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
