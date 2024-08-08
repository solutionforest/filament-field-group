<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes;

#[\Attribute]
class ConfigName
{
    public function __construct(
        public string $name,
        public string $label,
        public string $group,
    ) {}
}
