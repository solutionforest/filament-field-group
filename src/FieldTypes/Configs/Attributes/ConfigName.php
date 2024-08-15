<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes;

use Attribute;

/**
 * @property string $name The name of the field type configuration.
 * @property string $label The label of the field type configuration.
 * @property string $group The group of the field type configuration.
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class ConfigName
{
    public function __construct(
        public string $name,
        public string $label,
        public string $group,
    ) {}
}
