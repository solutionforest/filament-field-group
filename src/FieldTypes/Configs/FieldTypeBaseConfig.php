<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs;

use Filament\Forms;
use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Macroable;
use ReflectionClass;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\ConfigName;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\DbType;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\FormComponent;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts\FieldTypeConfig;

abstract class FieldTypeBaseConfig implements Contracts\FieldTypeConfig
{
    use Macroable;

    abstract public function applyConfig(Forms\Components\Component $component): void;

    abstract public function getFormSchema(): array;

    /**
     * Build a new FieldTypeConfig object from JSON data.
     *
     * @return null|FieldTypeConfig|FieldTypeBaseConfig
     */
    public static function make(string | array $data)
    {
        try {
            if (is_string($data)) {
                $data = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
            }

            $class = new ReflectionClass(static::class);
            $object = $class->newInstanceWithoutConstructor();

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

        return null;
    }

    protected static function fiComponentHasTrait($component, $trait): bool
    {
        if (in_array($trait, class_uses($component))) {
            return true;
        }

        // Check parent
        $parent = get_parent_class($component);
        if ($parent) {
            return static::fiComponentHasTrait($parent, $trait);
        }

        return false;
    }

    /** {@inheritDoc} */
    public static function getFormComponents(): array
    {
        $attributes = static::findFieldConfigAttribute(static::class, FormComponent::class);

        $result = [];

        // Map the attributes to array
        foreach ($attributes as $attribute) {
            $attributeInstance = $attribute->newInstance();
            $result[] = [
                'component' => $attributeInstance->fqcn,
            ];
        }

        return $result;
    }

    /** {@inheritDoc} */
    public static function getConfigNames(): array
    {
        $attributes = static::findFieldConfigAttribute(static::class, ConfigName::class);

        $result = [];
        // Map the attributes to array
        foreach ($attributes as $attribute) {
            $attributeInstance = $attribute->newInstance();
            $result[] = [
                'name' => $attributeInstance->name,
                'label' => $attributeInstance->label,
                'group' => $attributeInstance->group,
                'icon' => $attributeInstance->icon,
            ];
        }

        return $result;
    }

    /** {@inheritDoc} */
    public static function getDbTypeMapping(?string $drive = null): array
    {
        $attributes = static::findFieldConfigAttribute(static::class, DbType::class);

        // Map the attributes to array
        foreach ($attributes as $attribute) {

            $attributeInstance = $attribute->newInstance();

            // throw exception if drive is duplicated in mapping
            if (isset($mapping[$attributeInstance->drive])) {
                throw new \Exception("The drive {$attributeInstance->drive} is duplicated in the mapping.");
            }

            $mapping[$attributeInstance->drive] = [
                'type' => $attributeInstance->type,
                'length' => $attributeInstance->length,
            ];
        }

        if ($drive) {
            return $mapping[$drive] ?? [];
        }

        return $mapping;
    }

    public function __toArray(): array
    {
        return get_object_vars($this);
    }

    /**
     * Convert the object to its JSON representation.
     */
    public function __toString(): string
    {
        return json_encode($this->__toArray());
    }

    private static function findFieldConfigAttribute($objectOrFQCN, $attributeFQCN, ?\Closure $extraCheck = null)
    {
        $reflection = new ReflectionClass($objectOrFQCN);

        $attributes = $reflection->getAttributes();

        return Arr::where($attributes, function ($attribute) use ($attributeFQCN, $extraCheck) {
            $attributeInstance = $attribute->newInstance();

            return $attribute->getName() === $attributeFQCN &&
                ($extraCheck ? $extraCheck($attributeInstance) : true);
        });
    }
}
