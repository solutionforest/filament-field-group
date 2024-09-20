<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs;

use Filament\Forms;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\ConfigName;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\DbType;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\FormComponent;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts\FieldTypeConfig;

#[ConfigName('toggle', 'Toggle', 'Choices', 'heroicon-o-adjustments-horizontal')]
#[FormComponent(Forms\Components\Toggle::class)]
#[DbType('mysql', 'tinyint')]
#[DbType('sqlite', 'tinyint')]
class Toggle extends FieldTypeBaseConfig implements FieldTypeConfig
{
    public function getFormSchema(): array
    {
        return [];
    }

    public function applyConfig(Forms\Components\Component $component): void {}
}
