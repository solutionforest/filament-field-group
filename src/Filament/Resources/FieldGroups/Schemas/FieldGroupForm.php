<?php

namespace SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Schemas;

use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Livewire\Component as Livewire;
use SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Schemas\Components\FieldGroupActiveToggle;
use SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Schemas\Components\FieldGroupNameInput;
use SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Schemas\Components\FieldGroupTitleInput;

class FieldGroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components(
                fn ($livewire, $operation) => self::isEditing($livewire, $operation)
                    ? [
                        Section::make()
                            ->schema([
                                FieldGroupTitleInput::make(),
                            ]),
                        Section::make()
                            ->heading(__('filament-field-group::filament-field-group.settings'))
                            ->collapsible()->collapsed()
                            ->schema([
                                FieldGroupNameInput::make(),
                                FieldGroupActiveToggle::make(),
                            ]),
                    ]
                    : [
                        FieldGroupTitleInput::make(),
                        FieldGroupNameInput::make(),
                    ]
            );
    }

    private static function isEditing(Livewire $livewire, $operation): bool
    {
        if ($livewire instanceof EditRecord) {
            return true;
        }

        if ($operation == 'edit') {
            return true;
        }

        return false;
    }
}
