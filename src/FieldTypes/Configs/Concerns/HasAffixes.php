<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Concerns;

use Filament\Forms\Components\TextInput;
use Filament\Forms;

trait HasAffixes
{
    public ?string $prefixLabel = null;

    public ?string $suffixLabel = null;

    protected static function getHasAffixesFormComponent($name)
    {
        return match ($name) {
            'prefixLabel' => TextInput::make('prefixLabel'),
            'suffixLabel' => TextInput::make('suffixLabel'),
            default => null,
        };
    }
}
