<?php

// config for SolutionForest/FilamentFieldGroup
return [
    'enabled' => false,
    // Group by field group
    'field_types' => [
        \SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Text::class,
        \SolutionForest\FilamentFieldGroup\FieldTypes\Configs\TextArea::class,
        \SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Email::class,
        \SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Password::class,
        \SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Number::class,
        \SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Url::class,
        \SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Select::class,
    ],
    'models' => [
        'field' => \SolutionForest\FilamentFieldGroup\Models\Field::class,
        'field_group' => SolutionForest\FilamentFieldGroup\Models\FieldGroup::class,
    ],
    'table_names' => [
        'fields' => 'advanced_fields',
        'field_groups' => 'advanced_field_groups',
    ],
];
