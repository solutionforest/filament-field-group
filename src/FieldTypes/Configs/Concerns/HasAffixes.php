<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Concerns;

use Filament\Forms;

trait HasAffixes
{
    public ?string $prefixLabel = null;

    public ?string $suffixLabel = null;

    protected static function getHasAffixesFormComponent($name)
    {
        return match ($name) {
            'prefixLabel' => Forms\Components\TextInput::make('prefixLabel'),
            'suffixLabel' => Forms\Components\TextInput::make('suffixLabel'),
            default => null,
        };
    }
}
