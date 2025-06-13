<?php

namespace SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Schemas\Components;

use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;

class FieldGroupNameInput
{
    public static function make(): TextInput
    {
        return TextInput::make('name')
            ->label(__('filament-field-group::filament-field-group.name'))
            ->hint('e.g. `user_profile`')
            ->helperText('Unique name for the field group.')
            ->required()
            ->maxLength(255)
            ->live(debounce: 500)
            ->afterStateUpdated(fn ($component, $state) => $component->state(Str::slug($state, '_')))
            ->unique(ignoreRecord: true);
    }
}
