<?php

namespace SolutionForest\FilamentFieldGroup\Concerns;

trait HasFieldTypes
{
    protected array $fieldTypeConfigs = [
        \SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Text::class,
        \SolutionForest\FilamentFieldGroup\FieldTypes\Configs\TextArea::class,
        \SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Email::class,
        \SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Password::class,
        \SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Number::class,
        \SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Url::class,
        \SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Select::class,
        \SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Toggle::class,
        \SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Radio::class,
        \SolutionForest\FilamentFieldGroup\FieldTypes\Configs\File::class,
        \SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Image::class,
        \SolutionForest\FilamentFieldGroup\FieldTypes\Configs\ColorPicker::class,
        \SolutionForest\FilamentFieldGroup\FieldTypes\Configs\DateTimePicker::class,
    ];

    public function fieldTypeConfigs(array $fieldTypeConfigs, bool $override = true): void
    {
        if ($override) {
            $this->fieldTypeConfigs = $fieldTypeConfigs;
        } else {
            $this->fieldTypeConfigs = array_merge($this->fieldTypeConfigs, $fieldTypeConfigs);
        }
    }

    public function getFieldTypeConfigs(): array
    {
        return $this->fieldTypeConfigs;
    }
}
