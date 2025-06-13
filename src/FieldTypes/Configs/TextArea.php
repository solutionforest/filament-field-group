<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs;

use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts\FieldTypeConfig;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Concerns\HasDefaultValue;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Concerns\HasRules;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Forms;
use Filament\Forms\Components\Concerns\CanBeValidated;
use Filament\Forms\Components\Concerns\HasPlaceholder;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\ConfigName;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\DbType;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\FormComponent;

#[ConfigName('textArea', 'Text Area', 'General', 'heroicon-o-pencil')]
#[FormComponent(Forms\Components\Textarea::class)]
#[DbType('mysql', 'text')]
#[DbType('sqlite', 'text')]
class TextArea extends FieldTypeBaseConfig implements FieldTypeConfig
{
    use HasDefaultValue;
    use Concerns\HasPlaceholder;
    use HasRules;

    public ?int $rows = null;

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
                            TextInput::make('rows')
                                ->integer()
                                ->minValue(1),
                            static::getHasDefaultValueFormComponent('defaultValue'),
                            static::getHasPlaceholderFormComponent('placeholder'),
                        ]),
                ]),
        ];
    }

    public function applyConfig(Component $component): void
    {
        if (static::fiComponentHasTrait($component, CanBeValidated::class)) {
            if ($this->rule) {
                $component->rule($this->rule);
            }
        }
        if (static::fiComponentHasTrait($component, HasPlaceholder::class)) {
            if ($this->placeholder) {
                $component->placeholder($this->placeholder);
            }
        }
        if ($this->defaultValue != null) {
            $component->default($this->defaultValue);
        }
        if ($this->rows != null && $this->rows > 0) {
            $component->rows($this->rows);
        }
    }
}
