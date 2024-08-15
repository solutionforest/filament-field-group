<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes;

use Attribute;

/**
 * @property string $fqcn The fully qualified class name of the form component.
 */
#[Attribute(Attribute::TARGET_CLASS)]
class FormComponent
{
    public function __construct(
        public string $fqcn,
    ) {}
}
