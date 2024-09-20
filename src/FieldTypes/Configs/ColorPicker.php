<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs;

use Filament\Forms;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\ConfigName;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\DbType;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\FormComponent;

#[ConfigName('colorPicker', 'Color Picker', 'Picker', 'heroicon-o-paint-brush')]
#[FormComponent(Forms\Components\ColorPicker::class)]
#[DbType('mysql', 'varchar')]
#[DbType('sqlite', 'text')]
class ColorPicker extends FieldTypeBaseConfig implements Contracts\FieldTypeConfig
{
    use Concerns\HasDefaultValue;

    public function getFormSchema(): array
    {
        return [
            Forms\Components\Tabs::make('tabs')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('Presentation')
                        ->schema([
                            static::getHasDefaultValueFormComponent('defaultValue'),
                        ]),
                ]),
        ];
    }

    public function applyConfig(Forms\Components\Component $component): void
    {
        if ($this->defaultValue != null) {
            $component->default($this->defaultValue);
        }
    }
}
