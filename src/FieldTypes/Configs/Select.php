<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs;

use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts\FieldTypeConfig;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Concerns\HasDefaultValue;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Concerns\HasRules;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Component;
use Filament\Forms;
use Filament\Forms\Components\Concerns\CanBeValidated;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\ConfigName;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\DbType;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\FormComponent;

#[ConfigName('select', 'Select', 'Choices', 'heroicon-o-chevron-up-down')]
#[FormComponent(Forms\Components\Select::class)]
#[DbType('mysql', 'varchar')]
#[DbType('sqlite', 'text')]
class Select extends FieldTypeBaseConfig implements FieldTypeConfig
{
    use HasDefaultValue;
    use HasRules;

    public array $options = [];

    public bool $multiple = false;

    /**
     * Get the form schema for the field type.
     */
    public function getFormSchema(): array
    {
        return [
            Tabs::make('tabs')
                ->tabs([
                    Tab::make('Validation')
                        ->schema([
                            static::getHasRulesFormComponent('rule'),
                        ]),
                    Tab::make('Presentation')
                        ->schema([
                            KeyValue::make('options')
                                ->keyLabel('Value')
                                ->valueLabel('Label'),
                            Toggle::make('multiple')
                                ->inlineLabel()
                                ->default(false),
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

    /**
     * Apply the configuration to the component.
     */
    public function applyConfig(Component $component): void
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
