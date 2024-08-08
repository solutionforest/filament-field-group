<?php

namespace SolutionForest\FilamentFieldGroup\Facades;

use Filament\Forms;
use Illuminate\Support\Facades\Facade;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts\FieldTypeConfig;

/**
 * @method array getFieldTypeOptions()
 * @method array getFieldTypeGroupedKeyValueOptions()
 * @method ?string getFieldTypeDisplayValue(string $name)
 * @method array getFieldTypeConfigFormSchema(string $name)
 * @method ?Forms\Components\Component findFieldGroup(string $name)
 * @method ?FieldTypeConfig getFieldTypeConfig(string $name, array | string $data = [])
 *
 * @see \SolutionForest\FilamentFieldGroup\FilamentFieldGroup
 */
class FilamentFieldGroup extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \SolutionForest\FilamentFieldGroup\FilamentFieldGroup::class;
    }
}
