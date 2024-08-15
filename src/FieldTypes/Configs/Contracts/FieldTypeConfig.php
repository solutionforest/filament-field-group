<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts;

use Filament\Forms;

interface FieldTypeConfig
{
    /**
     * Get the form schema for the field type.
     */
    public function getFormSchema(): array;

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
}
