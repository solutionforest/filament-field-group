<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts;

use Filament\Forms;
use ReflectionAttribute;

interface FieldTypeConfig
{
    /**
     * Get the form schema for the field type.
     */
    public function getFormSchema(): array;

    /**
     * Get the form schema for the field type configuration.
     *
     * @return array
     */
    public function getFormSchemaForConfig();

    /**
     * Apply the configuration to the component.
     */
    public function applyConfig(Forms\Components\Component $component): void;

    /**
     * Get the form components for the field type.
     *
     * @return array<int,array<string,string>>
     */
    public static function getFormComponents(): array;

    /**
     * Get the configuration names for the field type.
     *
     * @return array<int,array<string,string>>
     */
    public static function getConfigNames(): array;

    /**
     * Get the database type mapping for the field type.
     *
     * @return array<string,mixed> | array<string,array<string,mixed>>
     */
    public static function getDbTypeMapping(?string $drive = null): array;

    /**
     * Retrieves the attributes associated with the field type.
     *
     * @return array<mixed>|ReflectionAttribute[]
     */
    public static function getFieldAttributes();
    
    /**
     * Retrieves the attributes associated with the target class.
     * 
     * @param class-string $target
     * @return ReflectionAttribute[]
     */
    public static function getTargetFieldAttributes($target);
}
