<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs;

use Filament\Forms\Components\TextInput;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts\FieldTypeConfig;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Concerns\HasDefaultValue;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Concerns\HasRules;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Component;
use Filament\Forms;
use Filament\Forms\Components\Concerns\CanBeValidated;
use Filament\Forms\Components\Concerns\HasAffixes;
use Filament\Forms\Components\Concerns\HasPlaceholder;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\ConfigName;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\DbType;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\FormComponent;

#[ConfigName('number', 'Number', 'General', 'heroicon-o-hashtag')]
#[FormComponent(TextInput::class)]
#[DbType('mysql', 'decimal')]
#[DbType('sqlite', 'numeric')]
class Number extends FieldTypeBaseConfig implements FieldTypeConfig
{
    use Concerns\HasAffixes;
    use HasDefaultValue;
    use Concerns\HasPlaceholder;
    use HasRules;

    public ?int $minValue = null;

    public ?int $maxValue = null;

    public function getFormSchema(): array
    {
        return [
            Tabs::make('tabs')
                ->tabs([
                    Tab::make('Validation')
                        ->schema([
                            static::getHasRulesFormComponent('rule'),
                            TextInput::make('minValue')->numeric(),
                            TextInput::make('maxValue')->numeric(),
                        ]),
                    Tab::make('Presentation')
                        ->schema([
                            static::getHasDefaultValueFormComponent('defaultValue'),
                            static::getHasPlaceholderFormComponent('placeholder'),
                            static::getHasAffixesFormComponent('prefixLabel'),
                            static::getHasAffixesFormComponent('suffixLabel'),
                        ]),
                ]),
        ];
    }

    public function applyConfig(Component $component): void
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
        if ($component instanceof TextInput) {
            $component->numeric();
        }
    }
}
