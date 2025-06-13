<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Concerns;

use Filament\Forms\Components\Textarea;

trait HasRules
{
    public ?array $rule = null;

    protected static function getHasRulesFormComponent($name)
    {
        return match ($name) {
            'rule' => Textarea::make('rule')
                ->helperText('Separate multiple rules with a pipe (|).')
                ->afterStateHydrated(function ($state, $component) {
                    if ($state === null) {
                        return;
                    }
                    if (is_array($state)) {
                        $state = implode('|', $state);
                    }
                    $component->state($state);
                })
                ->dehydrateStateUsing(function ($state) {
                    if ($state === null) {
                        return [];
                    }

                    return explode('|', $state);
                }),
            default => null,
        };
    }
}
