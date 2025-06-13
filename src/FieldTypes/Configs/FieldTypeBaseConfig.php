<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs;

use Filament\Schemas\Components\Component;
use Illuminate\Support\Traits\Macroable;
use ReflectionAttribute;
use ReflectionClass;
use SolutionForest\FilamentFieldGroup\Facades\FilamentFieldGroup;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\ConfigName;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\DbType;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\FormComponent;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts\FieldTypeConfig;

abstract class FieldTypeBaseConfig implements Contracts\FieldTypeConfig
{
    use Macroable;

    abstract public function applyConfig(Component $component): void;

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
    public function getFormSchemaForConfig()
    {
        return FilamentFieldGroup::configureFieldTypeConfigForm(
            $this,
            $this->getFormSchema()
        );
    }

    /** {@inheritDoc} */
    public static function getFormComponents(): array
    {
        return collect(static::getTargetFieldAttributes(FormComponent::class))
            ->pluck('fqcn')
            ->map(fn ($fqcn) => ['component' => $fqcn])
            ->all();

    }

    /** {@inheritDoc} */
    public static function getConfigNames(): array
    {
        $attributes = static::getTargetFieldAttributes(ConfigName::class);

        foreach ($attributes as $attribute) {
            if (! $attribute instanceof ConfigName) {
                continue;
            }
            $result[] = [
                'name' => $attribute->name,
                'label' => $attribute->label,
                'group' => $attribute->group,
                'icon' => $attribute->icon,
            ];
        }

        return $result ?? [];
    }

    /** {@inheritDoc} */
    public static function getDbTypeMapping(?string $drive = null): array
    {
        $attributes = static::getTargetFieldAttributes(DbType::class);

        $mapping = [];

        // Map the attributes to array
        foreach ($attributes as $attribute) {
            if (! $attribute instanceof DbType) {
                continue;
            }

            // throw exception if drive is duplicated in mapping
            if (isset($mapping[$attribute->drive])) {
                throw new \Exception("The drive {$attribute->drive} is duplicated in the mapping.");
            }

            $mapping[$attribute->drive] = [
                'type' => $attribute->type,
                'length' => $attribute->length,
            ];
        }

        if ($drive) {
            return $mapping[$drive] ?? [];
        }

        return $mapping ?? [];
    }

    /** {@inheritDoc} */
    public static function getFieldAttributes()
    {
        $reflection = new ReflectionClass(static::class);

        return $reflection->getAttributes();
    }

    /** {@inheritDoc} */
    public static function getTargetFieldAttributes($target)
    {
        return collect(static::getFieldAttributes())
            ->whereInstanceOf(ReflectionAttribute::class)
            ->filter(fn (ReflectionAttribute $attribute) => $attribute->getName() === $target)
            ->map(fn (ReflectionAttribute $attribute) => $attribute->newInstance())
            ->all();
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
