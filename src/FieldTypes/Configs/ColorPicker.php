<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\ConfigName;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\DbType;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\FormComponent;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Concerns\HasDefaultValue;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts\FieldTypeConfig;

#[ConfigName('colorPicker', 'Color Picker', 'Picker', 'heroicon-o-paint-brush')]
#[FormComponent(Forms\Components\ColorPicker::class)]
#[DbType('mysql', 'varchar')]
#[DbType('sqlite', 'text')]
class ColorPicker extends FieldTypeBaseConfig implements FieldTypeConfig
{
    use HasDefaultValue;

    public string $colorFormat = 'hex';

    public function getFormSchema(): array
    {
        return [
            Tabs::make('tabs')
                ->tabs([
                    Tab::make('Presentation')
                        ->schema([
                            Select::make('colorFormat')
                                ->options(collect(['hsl', 'rgb', 'rgba', 'hex'])
                                    ->mapWithKeys(fn ($item) => [$item => str($item)->upper()])
                                    ->toArray())
                                ->default('hex')
                                ->required()
                                ->selectablePlaceholder(false),
                            static::getHasDefaultValueFormComponent('defaultValue'),
                        ]),
                ]),
        ];
    }

    public function applyConfig(Component $component): void
    {
        if ($this->defaultValue != null) {
            $component->default($this->defaultValue);
        }
        if ($component instanceof Forms\Components\ColorPicker) {
            if ($this->colorFormat != null) {
                $component->format($this->colorFormat);
            }
        }
    }
}
