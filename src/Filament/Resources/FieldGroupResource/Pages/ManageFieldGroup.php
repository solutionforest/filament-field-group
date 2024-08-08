<?php

namespace SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroupResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroupResource;

class ManageFieldGroup extends ManageRecords
{
    protected static string $resource = FieldGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->createAnother(false)
                ->after(function ($action, $record) {
                    // Redirect to the edit page after creating a record.
                    $url = static::getResource()::getUrl('edit', ['record' => $record]);

                    return redirect($url);
                }),
        ];
    }
}
