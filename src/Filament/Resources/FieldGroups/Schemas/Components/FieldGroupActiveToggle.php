<?php

namespace SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Schemas\Components;

use Filament\Forms\Components\Toggle;

class FieldGroupActiveToggle
{
    public static function make(): Toggle
    {
        return Toggle::make('active')
            ->label(__('filament-field-group::filament-field-group.active'))
            ->inlineLabel()
            ->default(true);
    }
}
