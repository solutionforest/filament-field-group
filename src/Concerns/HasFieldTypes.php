<?php

namespace SolutionForest\FilamentFieldGroup\Concerns;

use Closure;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts\FieldTypeConfig;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\FieldTypeBaseConfig;

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

    /**
     * @var array<class-string<FieldTypeConfig>|class-string<FieldTypeBaseConfig>, array<Closure>>
     */
    protected array $configuringFieldTypes = [];

    public function fieldTypeConfigs(array $fieldTypeConfigs, bool $override = true): void
    {
        if ($override) {
            $this->fieldTypeConfigs = $fieldTypeConfigs;
        } else {
            $this->fieldTypeConfigs = array_merge($this->fieldTypeConfigs, $fieldTypeConfigs);
        }
    }

    /**
     * @return array<class-string<FieldTypeConfig>>|array<class-string<FieldTypeBaseConfig>>
     */
    public function getFieldTypeConfigs(): array
    {
        return $this->fieldTypeConfigs;
    }

    /**
     * @param class-string<FieldTypeBaseConfig>|class-string<FieldTypeConfig> $fieldTypeConfig
     * @param Closure $callback
     */
    public function configureFieldTypeConfigFormUsing($fieldTypeConfig, $callback)
    {
        if (!is_a($fieldTypeConfig, FieldTypeConfig::class, true)) {
            throw new \InvalidArgumentException('FieldTypeConfig must be an instance of ' . FieldTypeConfig::class . '.');
        }
        
        $this->configuringFieldTypes[$fieldTypeConfig][] = $callback;

        return $this;
    }

    /**
     * @param class-string<FieldTypeBaseConfig>|class-string<FieldTypeConfig>|FieldTypeBaseConfig|FieldTypeConfig $fieldTypeConfig
     * @param array $schema
     * 
     * @return array
     */
    public function configureFieldTypeConfigForm($fieldTypeConfig, $schema)
    {
        if (!is_a($fieldTypeConfig, FieldTypeConfig::class, true)) {
            throw new \InvalidArgumentException('FieldTypeConfig must be an instance of ' . FieldTypeConfig::class . '.');
        }

        $fieldTypeFqcn = is_string($fieldTypeConfig) ? $fieldTypeConfig : get_class($fieldTypeConfig);

        $configure = $this->configuringFieldTypes[$fieldTypeFqcn] ?? [];
        if (!empty($configure) && is_array($configure)) {
            foreach ($configure as $callback) {
                $schema = $callback($fieldTypeConfig, $schema);
            }
        }

        return $schema;
    }
}
