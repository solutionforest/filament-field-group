<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs;

use Filament\Forms\Components\TextInput;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts\FieldTypeConfig;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Concerns\HasRules;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Component;
use Filament\Forms;
use Filament\Forms\Components\Concerns\CanBeValidated;
use Filament\Forms\Components\Concerns\HasPlaceholder;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\ConfigName;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\DbType;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\FormComponent;

#[ConfigName('password', 'Password', 'General', 'heroicon-o-lock-closed')]
#[FormComponent(TextInput::class)]
#[DbType('mysql', 'varchar')]
#[DbType('sqlite', 'text')]
class Password extends FieldTypeBaseConfig implements FieldTypeConfig
{
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
                        ]),
                    Tab::make('Presentation')
                        ->schema([
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
        if ($component instanceof TextInput) {
            $component->password();
        }
    }
}
