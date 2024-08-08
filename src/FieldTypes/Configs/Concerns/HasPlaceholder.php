<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Concerns;

use Filament\Forms;

trait HasPlaceholder
{
    public ?string $placeholder = null;

    protected static function getHasPlaceholderFormComponent($name)
    {
        return match ($name) {
            'placeholder' => Forms\Components\TextInput::make('placeholder')
                ->maxLength(255),
            default => null,
        };
    }
}
