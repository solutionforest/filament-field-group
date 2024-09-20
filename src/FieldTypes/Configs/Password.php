<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs;

use Filament\Forms;
use Filament\Forms\Components\Concerns\CanBeValidated;
use Filament\Forms\Components\Concerns\HasPlaceholder;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\ConfigName;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\DbType;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\FormComponent;

#[ConfigName('password', 'Password', 'General', 'heroicon-o-lock-closed')]
#[FormComponent(Forms\Components\TextInput::class)]
#[DbType('mysql', 'varchar')]
#[DbType('sqlite', 'text')]
class Password extends FieldTypeBaseConfig implements Contracts\FieldTypeConfig
{
    use Concerns\HasPlaceholder;
    use Concerns\HasRules;

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
                            static::getHasPlaceholderFormComponent('placeholder'),
                        ]),
                ]),
        ];
    }

    public function applyConfig(Forms\Components\Component $component): void
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
        if ($component instanceof Forms\Components\TextInput) {
            $component->password();
        }
    }
}
