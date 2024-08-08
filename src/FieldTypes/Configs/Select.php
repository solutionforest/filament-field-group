<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs;

use Filament\Forms;
use Filament\Forms\Components\Concerns\CanBeValidated;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\ConfigName;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\FormComponent;

#[ConfigName('select', 'Select', 'Choices')]
#[FormComponent(Forms\Components\Select::class)]
class Select extends FieldTypeBaseConfig implements Contracts\FieldTypeConfig
{
    use Concerns\HasDefaultValue;
    use Concerns\HasRules;

    public array $options = [];

    public bool $multiple = false;

    /**
     * Get the form schema for the field type.
     */
    public function getFormSchema(): array
    {
        return [
            Forms\Components\Tabs::make('tabs')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('Validation')
                        ->schema([
                            static::getHasRulesFormComponent('rule'),
                        ]),
                    Forms\Components\Tabs\Tab::make('Presentation')
                        ->schema([
                            Forms\Components\KeyValue::make('options')
                                ->keyLabel('Value')
                                ->valueLabel('Label'),
                            Forms\Components\Toggle::make('multiple')
                                ->inlineLabel()
                                ->default(false),
                            Forms\Components\Textarea::make('defaultValue')
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

    /**
     * Apply the configuration to the component.
     */
    public function applyConfig(Forms\Components\Component $component): void
    {
        $component->options($this->options);

        if (static::fiComponentHasTrait($component, CanBeValidated::class)) {
            if ($this->rule) {
                $component->rule($this->rule);
            }
        }

        if ($this->multiple) {
            $component->multiple();
        }

        if ($this->defaultValue !== null) {
            $component->default($this->defaultValue);
        }
    }
}
