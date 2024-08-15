<?php

namespace SolutionForest\FilamentFieldGroup;

use Filament\Forms;
use Illuminate\Support\Arr;
use ReflectionClass;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\ConfigName;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\FormComponent;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts\FieldTypeConfig;
use SolutionForest\FilamentFieldGroup\Models\FieldGroup;

class FilamentFieldGroup
{
    public function getFieldTypeOptions(): array
    {
        $fieldTypes = FilamentFieldGroupPlugin::get()->getFieldTypeConfigs();

        $result = [];

        foreach ($fieldTypes as $fieldFQCN) {

            $targetAttributes = $this->findFieldConfigAttribute($fieldFQCN, ConfigName::class);

            if (count($targetAttributes) === 0) {
                continue;
            }

            $attributeInstance = $targetAttributes[0]->newInstance();

            $result[] = [
                'name' => $attributeInstance->name,
                'display' => $attributeInstance->label,
                'group' => $attributeInstance->group,
            ];
        }

        return $result;
    }

    /**
     * Return the field type options grouped by group as key value pairs.
     */
    public function getFieldTypeGroupedKeyValueOptions(): array
    {
        return collect($this->getFieldTypeOptions())->mapToGroups(function ($item) {
            return [$item['group'] => $item];
        })->mapWithKeys(function ($options, $group) {
            return [$group => Arr::pluck($options, 'display', 'name')];
        })->toArray();
    }

    /**
     * @param  string  $name
     */
    public function getFieldTypeDisplayValue($name): ?string
    {
        $fieldTypeConfig = $this->getFieldTypeConfig($name);

        if (! $fieldTypeConfig) {
            return null;
        }

        // Get the display value from the attribute of the field type
        $attributes = $this->findFieldConfigAttribute($fieldTypeConfig, ConfigName::class);

        if (count($attributes) === 0) {
            return null;
        }

        return $attributes[0]->newInstance()->label;
    }

    /**
     * @param  string  $name
     */
    public function getFieldTypeConfigFormSchema($name): array
    {
        $fieldTypeConfig = $this->getFieldTypeConfig($name);

        if (! $fieldTypeConfig) {
            return [];
        }

        try {

            return $fieldTypeConfig->getFormSchema();

        } catch (\Throwable $e) {
            // Throw have error while getting form schema
            throw new \Exception("The form schema is invalid for the field type config class {$name}.", previous: $e);
        }
    }

    public function findFieldGroup($name): ?Forms\Components\Component
    {
        $fieldGroup = static::fieldGroupModel()::with('fields')->where('name', $name)->first();

        if (! $fieldGroup) {
            return null;
        }

        $schema = [];

        foreach ($fieldGroup->fields as $field) {
            $fiFormConfig = $this->getFieldTypeConfig($field->type, $field->config);

            if (! $fiFormConfig) {
                continue;
            }

            $fiFormComponentAttribute = Arr::first($this->findFieldConfigAttribute($fiFormConfig, FormComponent::class));
            if (! $fiFormComponentAttribute) {
                throw new \Exception("The field type config class {$fiFormConfig} does not have a FormComponent attribute.");
            }

            $fiFormComponentAttributeInstance = $fiFormComponentAttribute->newInstance();
            $fiFormComponentFQCN = $fiFormComponentAttributeInstance->fqcn;
            $fiFormComponent = $fiFormComponentFQCN::make($field->name);

            // @todo - some components may not have these methods
            $fiFormComponent->label($field->label);
            $fiFormComponent->helperText($field->instructions);
            $fiFormComponent->required($field->mandatory);

            $fiFormConfig->applyConfig($fiFormComponent);

            $schema[] = $fiFormComponent;
        }

        return Forms\Components\Section::make($fieldGroup->title)
            ->schema($schema);
    }

    /**
     * Get the field type config by name.
     *
     * @param  string  $name
     */
    public function getFieldTypeConfig($name, array | string $data = []): ?FieldTypeConfig
    {
        $fieldTypes = FilamentFieldGroupPlugin::get()->getFieldTypeConfigs();

        foreach ($fieldTypes as $fieldFQCN) {

            $targetAttributes = $this->findFieldConfigAttribute($fieldFQCN, ConfigName::class, function ($attributeInstance) use ($name) {
                return $attributeInstance->name === $name;
            });

            if (count($targetAttributes) > 0) {
                if (method_exists($fieldFQCN, 'make')) {
                    return $fieldFQCN::make($data);
                } else {
                    try {

                        if (is_string($data)) {
                            $data = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
                        }

                        // Apply the data params to the constructor
                        $reflection = new ReflectionClass($fieldFQCN);
                        $object = $reflection->newInstanceWithoutConstructor();

                        // Populate the object with the JSON data
                        foreach ($data as $key => $value) {
                            $object->$key = $value;
                        }

                        return $object;

                    } catch (\JsonException $e) {
                        throw new \InvalidArgumentException('Invalid JSON data provided.');
                    } catch (\ReflectionException $e) {
                        throw new \InvalidArgumentException('Invalid class provided.');
                    } catch (\Throwable $e) {
                        throw new \InvalidArgumentException('Invalid data provided.');
                    }
                }
            }
        }

        return null;
    }

    private function findFieldConfigAttribute($objectOrFQCN, $attributeFQCN, ?\Closure $extraCheck = null)
    {
        $reflection = new ReflectionClass($objectOrFQCN);

        $attributes = $reflection->getAttributes();

        return Arr::where($attributes, function ($attribute) use ($attributeFQCN, $extraCheck) {
            $attributeInstance = $attribute->newInstance();

            return $attribute->getName() === $attributeFQCN &&
                ($extraCheck ? $extraCheck($attributeInstance) : true);
        });
    }

    private function fieldGroupModel()
    {
        return config('filament-field-group.models.field_group', FieldGroup::class);
    }
}
