<?php

use SolutionForest\FilamentFieldGroup\Models\Field;
use SolutionForest\FilamentFieldGroup\Models\FieldGroup;

// config for SolutionForest/FilamentFieldGroup
return [
    'enabled' => false,
    'models' => [
        'field' => Field::class,
        'field_group' => FieldGroup::class,
    ],
    'table_names' => [
        'fields' => 'advanced_fields',
        'field_groups' => 'advanced_field_groups',
    ],
];
