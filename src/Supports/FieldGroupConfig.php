<?php

namespace SolutionForest\FilamentFieldGroup\Supports;

use SolutionForest\FilamentFieldGroup\Models\Field;
use SolutionForest\FilamentFieldGroup\Models\FieldGroup;

class FieldGroupConfig
{
    public static function getFieldGroupTableName(): string
    {
        return config('filament-field-group.table_names.field_groups', 'advanced_field_groups');
    }

    public static function getFieldGroupModelClass(): string
    {
        $class = config('filament-field-group.models.field_group', FieldGroup::class);

        return self::ensureClassExists($class, 'FieldGroup model');
    }

    public static function getFieldTableName(): string
    {
        return config('filament-field-group.table_names.fields', 'advanced_fields');
    }

    public static function getFieldModelClass(): string
    {
        $class = config('filament-field-group.models.fields', Field::class);

        return self::ensureClassExists($class, 'Field model');
    }

    /**
     * Ensure that a class exists, or throw an exception.
     *
     * @param  string  $class  The fully qualified class name
     * @param  string  $type  A description of the class type (e.g., 'model', 'service')
     * @return string The class name if it exists
     *
     * @throws \Exception If the class does not exist
     */
    protected static function ensureClassExists(string $class, string $type): string
    {
        if (! class_exists($class)) {
            throw new \Exception("The {$type} class '{$class}' does not exist. Please check your configuration.");
        }

        return $class;
    }
}
