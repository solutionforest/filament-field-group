<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Concerns;

use Filament\Forms\Components\TextInput;

trait HasDefaultValue
{
    public mixed $defaultValue = null;

    protected static function getHasDefaultValueFormComponent($name)
    {
        return match ($name) {
            'defaultValue' => TextInput::make('defaultValue')
                ->maxLength(255),
            default => null,
        };
    }
}
