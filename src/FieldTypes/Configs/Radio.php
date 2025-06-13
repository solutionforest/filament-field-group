<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs;

use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Component;
use Filament\Forms;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\ConfigName;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\DbType;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\FormComponent;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Concerns\HasDefaultValue;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts\FieldTypeConfig;

#[ConfigName('radio', 'Radio', 'Choices', 'heroicon-o-check-circle')]
#[FormComponent(Forms\Components\Radio::class)]
#[DbType('mysql', 'varchar')]
#[DbType('sqlite', 'text')]
class Radio extends FieldTypeBaseConfig implements FieldTypeConfig
{
    use HasDefaultValue;

    public array $options = [];

    public function getFormSchema(): array
    {
        return [
            Tabs::make('tabs')
                ->tabs([
                    Tab::make('Presentation')
                        ->schema([
                            KeyValue::make('options')
                                ->keyLabel('Value')
                                ->valueLabel('Label'),
                            Textarea::make('defaultValue')
                                ->helperText('Separate multiple default value with a pipe (|).')
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
                        ]),
                ]),
        ];
    }

    public function applyConfig(Component $component): void
    {
        $component->options($this->options);

        if ($this->defaultValue !== null) {
            $component->default($this->defaultValue);
        }
    }
}
