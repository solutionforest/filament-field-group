<?php

namespace SolutionForest\FilamentFieldGroup\Facades;

use Filament\Forms;
use Illuminate\Support\Facades\Facade;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts\FieldTypeConfig;

/**
 * @method static void registerModels()
 * @method static string getFieldGroupModelClass()
 * @method static void setFieldGroupModelClass(string $modelClass)
 * @method static string getFieldModelClass()
 * @method static void setFieldModelClass(string $modelClass)
 * @method static array getFieldTypeOptions()
 * @method static array getFieldTypeGroupedKeyValueOptions()
 * @method static ?string getFieldTypeDisplayValue(string $name)
 * @method static array getFieldTypeConfigFormSchema(string $name)
 * @method static ?Forms\Components\Component findFieldGroup(string $name)
 * @method static ?FieldTypeConfig getFieldTypeConfig(string $name, array | string $data = [])
 *
 * @see \SolutionForest\FilamentFieldGroup\FilamentFieldGroup
 */
class FilamentFieldGroup extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return \SolutionForest\FilamentFieldGroup\FilamentFieldGroup::class;
    }
}
