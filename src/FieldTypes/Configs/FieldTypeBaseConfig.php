<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs;

use Filament\Forms;
use ReflectionClass;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts\FieldTypeConfig;

abstract class FieldTypeBaseConfig implements Contracts\FieldTypeConfig
{
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
}
