<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs;

use Filament\Forms\Components\TextInput;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts\FieldTypeConfig;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Concerns\HasDefaultValue;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Concerns\HasRules;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Component;
use Filament\Forms\Components\Concerns\CanBeLengthConstrained;
use Filament\Forms\Components\Concerns\CanBeValidated;
use Filament\Forms\Components\Concerns\HasAffixes;
use Filament\Forms\Components\Concerns\HasPlaceholder;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\ConfigName;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\DbType;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\FormComponent;

#[ConfigName('text', 'Text', 'General', 'heroicon-o-pencil')]
#[FormComponent(TextInput::class)]
#[DbType('mysql', 'varchar')]
#[DbType('sqlite', 'text')]
class Text extends FieldTypeBaseConfig implements FieldTypeConfig
{
    use Concerns\CanBeLengthConstrained;
    use Concerns\HasAffixes;
    use HasDefaultValue;
    use Concerns\HasPlaceholder;
    use HasRules;

    public function getFormSchema(): array
    {
        return [
            Tabs::make('tabs')
                ->tabs([
                    Tab::make('Validation')
                        ->schema([
                            static::getHasRulesFormComponent('rule'),
                            static::getCanBeLengthConstrainedFormComponent('length'),
                            static::getCanBeLengthConstrainedFormComponent('maxLength'),
                            static::getCanBeLengthConstrainedFormComponent('minLength'),
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
        if (static::fiComponentHasTrait($component, CanBeLengthConstrained::class)) {
            if ($this->maxLength) {
                $component->maxLength($this->maxLength);
            }
            if ($this->minLength) {
                $component->minLength($this->minLength);
            }
        }
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
        if ($this->defaultValue != null) {
            $component->default($this->defaultValue);
        }
    }
}
