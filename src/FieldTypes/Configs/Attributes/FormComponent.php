<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes;

#[\Attribute]
class FormComponent
{
    public function __construct(
        public string $fqcn,
    ) {}
}
