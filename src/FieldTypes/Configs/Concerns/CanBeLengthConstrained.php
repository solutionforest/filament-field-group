<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Concerns;

use Filament\Forms;

trait CanBeLengthConstrained
{
    public ?int $length = null;

    public ?int $maxLength = null;

    public ?int $minLength = null;

    protected static function getCanBeLengthConstrainedFormComponent($name)
    {
        return match ($name) {
            'length' => Forms\Components\TextInput::make('length')
                ->integer()
                ->minValue(0)
                ->step(1),
            'maxLength' => Forms\Components\TextInput::make('maxLength')
                ->integer()
                ->minValue(0)
                ->step(1),
            'minLength' => Forms\Components\TextInput::make('minLength')
                ->integer()
                ->minValue(0)
                ->step(1),
            default => null,
        };
    }
}
