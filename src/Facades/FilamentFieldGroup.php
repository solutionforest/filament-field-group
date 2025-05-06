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
 * @method static void fieldTypeConfigs(array $fieldTypeConfigs, bool $override = true)
 * @method static array getFieldTypeConfigs()
 * @method static array getFieldTypeOptions()
 * @method static ?FieldTypeConfig getFieldTypeConfig(string $name, array | string $data = [])
 * @method static array getFieldTypeGroupedKeyValueOptions()
 * @method static array getFieldTypeGroupedKeyValueWithIconOptions(?string $search = null, array $excepts = [])
 * @method static ?string getFieldTypeDisplayValue(string $name)
 * @method static ?string getFieldTypeIcon(string $name)
 * @method static array getFieldTypeConfigFormSchema(string $name)
 * @method static ?Forms\Components\Component findFieldGroup(string $name)
 * @method static void configureFieldTypeConfigFormUsing(string $fieldTypeConfig, \Closure $callback)
 * @method static array configureFieldTypeConfigForm(string|FieldTypeConfig|FieldTypeBaseConfig $fieldTypeConfig, array $schema)
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
