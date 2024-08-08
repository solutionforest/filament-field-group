<?php

namespace Solutionforest\FilamentAdvancedFields\Filament\Resources\FieldGroupResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Solutionforest\FilamentAdvancedFields\Filament\Resources\FieldGroupResource;

class ListFieldGroup extends ListRecords
{
    protected static string $resource = FieldGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
