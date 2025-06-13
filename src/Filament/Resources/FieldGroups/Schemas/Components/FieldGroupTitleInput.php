<?php

namespace SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Schemas\Components;

use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;

class FieldGroupTitleInput
{
    public static function make(): TextInput
    {
        return TextInput::make('title')
            ->label(__('filament-field-group::filament-field-group.title'))
            ->required()
            ->maxLength(255)
            ->live(debounce: 500)
            ->afterStateUpdated(fn ($set, $state) => $set('name', Str::slug($state, '_')));
    }
}
