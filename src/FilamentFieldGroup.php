<?php

namespace SolutionForest\FilamentFieldGroup;

use Filament\Schemas\Components\Component;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use ReflectionClass;
use SolutionForest\FilamentFieldGroup\Concerns\HasFieldTypes;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts\FieldTypeConfig;
use SolutionForest\FilamentFieldGroup\Models\Contracts\Field;
use SolutionForest\FilamentFieldGroup\Models\Contracts\FieldGroup;
use SolutionForest\FilamentFieldGroup\Supports\FieldGroupConfig;

class FilamentFieldGroup
{
    use HasFieldTypes;

    /**
     * The collection of models to register.
     */
    protected array $models = [];

    public function registerModels(): void
    {
        $modelClasses = config('filament-field-group.models');

        foreach ($modelClasses as $modelClass) {
            $interfaceClass = $this->guessModelContractClass($modelClass);
            $this->models[$interfaceClass] = $modelClass;
            $this->bindModel($interfaceClass, $modelClass);
        }
    }

    public function getFieldGroupModelClass(): string
    {
        $interfaceClass = FieldGroup::class;

        return $this->getModelClass($interfaceClass);
    }

    public function setFieldGroupModelClass($modelClass)
    {
        $interfaceClass = FieldGroup::class;

        $this->validateClassIsEloquentModel($modelClass);

        config()->set('filament-field-group.models.field', $modelClass);

        $this->models[$interfaceClass] = $modelClass;

        $this->bindModel($interfaceClass, $modelClass);
    }

    public function getFieldModelClass(): string
    {
        $interfaceClass = Field::class;

        return $this->getModelClass($interfaceClass);
    }

    public function setFieldModelClass($modelClass): void
    {
        $interfaceClass = Field::class;

        $this->validateClassIsEloquentModel($modelClass);

        config()->set('filament-field-group.models.field', $modelClass);

        $this->models[$interfaceClass] = $modelClass;

        $this->bindModel($interfaceClass, $modelClass);
    }

    public function getFieldTypeOptions(): array
    {
        $fieldTypes = $this->getFieldTypeConfigs();

        $result = [];

        foreach ($fieldTypes as $fieldFQCN) {

            if (! in_array(FieldTypeConfig::class, class_implements($fieldFQCN))) {
                throw new \Exception("The field type config class {$fieldFQCN} does not implement the FieldTypeConfig interface.");
            }

            $targetAttributes = Arr::first($fieldFQCN::getConfigNames());

            if (! $targetAttributes) {
                throw new \Exception("The field type config class {$fieldFQCN} does not have a valid config names.");
            }

            if (count($targetAttributes) === 0 || ! $targetAttributes) {
                continue;
            }

            $result[] = [
                'name' => $targetAttributes['name'],
                'display' => $targetAttributes['label'],
                'group' => $targetAttributes['group'],
                'icon' => $targetAttributes['icon'],
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

    public function getFieldTypeGroupedKeyValueWithIconOptions(?string $search = null, array $excepts = []): array
    {
        $options = $this->getFieldTypeOptions();

        if (filled($search) && ! is_null($search)) {
            $options = Arr::where(
                $options,
                fn ($item) => str_contains($item['name'], $search)
            );
        }

        if (! empty($excepts)) {
            $options = Arr::where(
                $options,
                fn ($item) => ! in_array($item['name'], $excepts)
            );
        }

        return collect($options)
            ->groupBy('group')
            ->map(fn ($collection) => collect($collection)->mapWithKeys(function ($item) {

                $icon = $item['icon'] ?? null;
                $label = $item['display'] ?? $item['name'] ?? '';

                $textWithIconHtml = filled($icon) ?
                Blade::render(<<<'blade'
                        <div style="display:flex;gap:0.5rem;align-items:center;">
                            <x-filament::icon
                                icon="{{$icon}}"
                                class="h-5 w-5"
                            />
                            <span>
                                {{ $value }}
                            </span>
                        </div>
                    blade, ['icon' => $icon, 'value' => $label]) :
                    Blade::render(<<<'blade'
                        <div style="display:flex;gap:0.5rem;align-items:center;">
                            <div class="h-5 w-5"></div>
                            <span>
                                {{ $value }}
                            </span>
                        </div>
                    blade, ['value' => $label]);

                return [$item['name'] => $textWithIconHtml];
            }))
            ->toArray();
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

        if (! in_array(FieldTypeConfig::class, class_implements($fieldTypeConfig))) {
            throw new \Exception("The field type config class {$fieldTypeConfig} does not implement the FieldTypeConfig interface.");
        }

        // Get the display value from the attribute of the field type
        return data_get(Arr::first($fieldTypeConfig->getConfigNames()), 'label');
    }

    /**
     * @param  string  $name
     */
    public function getFieldTypeIcon($name): ?string
    {
        $fieldTypeConfig = $this->getFieldTypeConfig($name);

        if (! $fieldTypeConfig) {
            return null;
        }

        if (! in_array(FieldTypeConfig::class, class_implements($fieldTypeConfig))) {
            throw new \Exception("The field type config class {$fieldTypeConfig} does not implement the FieldTypeConfig interface.");
        }

        // Get the display value from the attribute of the field type
        return data_get(Arr::first($fieldTypeConfig->getConfigNames()), 'icon');
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

            return $fieldTypeConfig->getFormSchemaForConfig();

        } catch (\Throwable $e) {
            // Throw have error while getting form schema
            throw new \Exception("The form schema is invalid for the field type config class {$name}.", previous: $e);
        }
    }

    public function findFieldGroup($name): ?Component
    {
        $fieldGroup = FieldGroupConfig::getFieldGroupModelClass()::with('fields')->where('name', $name)->first();

        if (! $fieldGroup) {
            return null;
        }

        return $fieldGroup->toFilamentComponent();
    }

    /**
     * Get the field type config by name.
     *
     * @param  string  $name
     * @return FieldTypeConfig|null
     */
    public function getFieldTypeConfig($name, array | string $data = [])
    {
        $fieldTypes = $this->getFieldTypeConfigs();

        foreach ($fieldTypes as $fieldFQCN) {

            if (! in_array(FieldTypeConfig::class, class_implements($fieldFQCN))) {
                throw new \Exception("The field type config class {$fieldFQCN} does not implement the FieldTypeConfig interface.");
            }

            $targetAttributes = Arr::where($fieldFQCN::getConfigNames() ?? [], function ($attribute) use ($name) {
                return $attribute['name'] === $name;
            });

            if (! $targetAttributes) {
                continue;
            }

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

    // region Helper methods
    protected function replaceModelClass(string $interfaceClass, string $modelClass): void
    {
        switch ($interfaceClass) {
            case FieldGroup::class:
                $this->setFieldGroupModelClass($modelClass);

                break;
            case Field::class:
                $this->setFieldModelClass($modelClass);

                break;
        }
    }

    protected function getModelClass(string $interfaceClass, ?string $fallback = null): ?string
    {
        return $this->models[$interfaceClass] ?? $fallback;
    }

    /**
     * Bind a model to the interface in the container.
     *
     * @param  string  $interfaceClass  The interface class to bind.
     * @param  string  $modelClass  The model class to bind.
     */
    protected function bindModel(string $interfaceClass, string $modelClass): void
    {
        app()->bind($interfaceClass, $modelClass);
    }

    /**
     * Guess the contract class for a given model class.
     *
     * @param  string  $modelClass  The model class to guess the contract for.
     * @return string The guessed contract class name.
     */
    protected function guessModelContractClass(string $modelClass): string
    {
        $class = new \ReflectionClass($modelClass);

        $shortName = $class->getShortName();
        $namespace = $class->getNamespaceName();

        return "{$namespace}\\Contracts\\$shortName";
    }

    /**
     * Validate that a class is an Eloquent model.
     *
     * @param  string  $class  The class to validate.
     *
     * @throws \InvalidArgumentException If the class is not a subclass of Model.
     */
    private function validateClassIsEloquentModel(string $class): void
    {
        if (! is_subclass_of($class, Model::class)) {
            throw new \InvalidArgumentException(sprintf('Given [%s] is not a subclass of [%s].', $class, Model::class));
        }
    }
    // endregion Helper methods
}
