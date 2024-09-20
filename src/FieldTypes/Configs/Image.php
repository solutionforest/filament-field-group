<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs;

use Filament\Forms;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\ConfigName;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\DbType;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\FormComponent;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts\FieldTypeConfig;

#[ConfigName('image', 'Image', 'Content', 'heroicon-o-photo')]
#[FormComponent(Forms\Components\FileUpload::class)]
#[DbType('mysql', 'varchar')]
#[DbType('sqlite', 'text')]
class Image extends File implements FieldTypeConfig
{
    public function applyConfig(Forms\Components\Component $component): void
    {
        parent::applyConfig($component);

        $component->image();
    }
}
