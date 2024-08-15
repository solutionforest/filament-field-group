<?php

// config for SolutionForest/FilamentFieldGroup
return [
    'enabled' => false,
    'models' => [
        'field' => \SolutionForest\FilamentFieldGroup\Models\Field::class,
        'field_group' => SolutionForest\FilamentFieldGroup\Models\FieldGroup::class,
    ],
    'table_names' => [
        'fields' => 'advanced_fields',
        'field_groups' => 'advanced_field_groups',
    ],
];
