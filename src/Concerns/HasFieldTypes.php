<?php

namespace SolutionForest\FilamentFieldGroup\Concerns;

use Closure;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\ColorPicker;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts\FieldTypeConfig;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\DateTimePicker;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Email;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\FieldTypeBaseConfig;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\File;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Image;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Number;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Password;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Radio;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Select;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Text;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\TextArea;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Toggle;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Url;

trait HasFieldTypes
{
    protected array $fieldTypeConfigs = [
        Text::class,
        TextArea::class,
        Email::class,
        Password::class,
        Number::class,
        Url::class,
        Select::class,
        Toggle::class,
        Radio::class,
        File::class,
        Image::class,
        ColorPicker::class,
        DateTimePicker::class,
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
     * @param  class-string<FieldTypeBaseConfig>|class-string<FieldTypeConfig>  $fieldTypeConfig
     * @param  Closure  $callback
     */
    public function configureFieldTypeConfigFormUsing($fieldTypeConfig, $callback)
    {
        if (! is_a($fieldTypeConfig, FieldTypeConfig::class, true)) {
            throw new \InvalidArgumentException('FieldTypeConfig must be an instance of ' . FieldTypeConfig::class . '.');
        }

        $this->configuringFieldTypes[$fieldTypeConfig][] = $callback;

        return $this;
    }

    /**
     * @param  class-string<FieldTypeBaseConfig>|class-string<FieldTypeConfig>|FieldTypeBaseConfig|FieldTypeConfig  $fieldTypeConfig
     * @param  array  $schema
     * @return array
     */
    public function configureFieldTypeConfigForm($fieldTypeConfig, $schema)
    {
        if (! is_a($fieldTypeConfig, FieldTypeConfig::class, true)) {
            throw new \InvalidArgumentException('FieldTypeConfig must be an instance of ' . FieldTypeConfig::class . '.');
        }

        $fieldTypeFqcn = is_string($fieldTypeConfig) ? $fieldTypeConfig : get_class($fieldTypeConfig);

        $configure = $this->configuringFieldTypes[$fieldTypeFqcn] ?? [];
        if (! empty($configure) && is_array($configure)) {
            foreach ($configure as $callback) {
                $schema = $callback($fieldTypeConfig, $schema);
            }
        }

        return $schema;
    }
}
