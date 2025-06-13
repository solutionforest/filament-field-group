<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Concerns;

use Filament\Forms\Components\TextInput;
use Filament\Forms;

trait CanBeLengthConstrained
{
    public ?int $length = null;

    public ?int $maxLength = null;

    public ?int $minLength = null;

    protected static function getCanBeLengthConstrainedFormComponent($name)
    {
        return match ($name) {
            'length' => TextInput::make('length')
                ->integer()
                ->minValue(0)
                ->step(1),
            'maxLength' => TextInput::make('maxLength')
                ->integer()
                ->minValue(0)
                ->step(1),
            'minLength' => TextInput::make('minLength')
                ->integer()
                ->minValue(0)
                ->step(1),
            default => null,
        };
    }
}
