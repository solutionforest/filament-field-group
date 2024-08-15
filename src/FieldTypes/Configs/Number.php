<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs;

use Filament\Forms;
use Filament\Forms\Components\Concerns\CanBeValidated;
use Filament\Forms\Components\Concerns\HasAffixes;
use Filament\Forms\Components\Concerns\HasPlaceholder;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\ConfigName;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\DbType;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\FormComponent;

#[ConfigName('number', 'Number', 'General')]
#[FormComponent(Forms\Components\TextInput::class)]
#[DbType('mysql', 'decimal')]
#[DbType('sqlite', 'numeric')]
class Number extends FieldTypeBaseConfig implements Contracts\FieldTypeConfig
{
    use Concerns\HasAffixes;
    use Concerns\HasDefaultValue;
    use Concerns\HasPlaceholder;
    use Concerns\HasRules;

    public ?int $minValue = null;

    public ?int $maxValue = null;

    public function getFormSchema(): array
    {
        return [
            Forms\Components\Tabs::make('tabs')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('Validation')
                        ->schema([
                            static::getHasRulesFormComponent('rule'),
                            Forms\Components\TextInput::make('minValue')->numeric(),
                            Forms\Components\TextInput::make('maxValue')->numeric(),
                        ]),
                    Forms\Components\Tabs\Tab::make('Presentation')
                        ->schema([
                            static::getHasDefaultValueFormComponent('defaultValue'),
                            static::getHasPlaceholderFormComponent('placeholder'),
                            static::getHasAffixesFormComponent('prefixLabel'),
                            static::getHasAffixesFormComponent('suffixLabel'),
                        ]),
                ]),
        ];
    }

    public function applyConfig(Forms\Components\Component $component): void
    {
        if (static::fiComponentHasTrait($component, HasAffixes::class)) {
            if ($this->prefixLabel) {
                $component->prefix($this->prefixLabel);
            }
            if ($this->suffixLabel) {
                $component->suffix($this->suffixLabel);
            }
        }
        if (static::fiComponentHasTrait($component, HasPlaceholder::class)) {
            if ($this->placeholder) {
                $component->placeholder($this->placeholder);
            }
        }
        if (static::fiComponentHasTrait($component, CanBeValidated::class)) {
            if ($this->rule) {
                $component->rule($this->rule);
            }
        }
        if ($this->minValue) {
            $component->minValue($this->minValue);
        }
        if ($this->maxValue) {
            $component->maxValue($this->maxValue);
        }
        if ($this->defaultValue != null) {
            $component->default($this->defaultValue);
        }
        if ($component instanceof Forms\Components\TextInput) {
            $component->numeric();
        }
    }
}
