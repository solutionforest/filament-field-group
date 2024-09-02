<?php

namespace SolutionForest\FilamentFieldGroup\Base\Manifests;

use Illuminate\Database\Eloquent\Model;
use SolutionForest\FilamentFieldGroup\Models;

class ModelManifest implements ModelManifestInterface
{
    /**
     * The collection of models to register to this manifest.
     */
    protected array $models = [];

    /**
     * {@inheritdoc}
     */
    public function register(): void
    {
        $modelClasses = static::getDefaultModels();

        foreach ($modelClasses as $modelClass) {
            $interfaceClass = $this->guessContractClass($modelClass);
            $this->models[$interfaceClass] = $modelClass;
            $this->bindModel($interfaceClass, $modelClass);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function add(string $interfaceClass, string $modelClass): void
    {
        $this->validateClassIsEloquentModel($modelClass);

        $this->models[$interfaceClass] = $modelClass;

        $this->bindModel($interfaceClass, $modelClass);
    }

    /**
     * {@inheritdoc}
     */
    public function replace(string $interfaceClass, string $modelClass): void
    {
        $this->add($interfaceClass, $modelClass);
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $interfaceClass, ?string $fallback = null): ?string
    {
        return $this->models[$interfaceClass] ?? $fallback;
    }

    /**
     * Get the default models for registration.
     *
     * @return array The array of default model classes.
     */
    protected static function getDefaultModels(): array
    {
        return [
            Models\Field::class,
            Models\FieldGroup::class,
        ];
    }

    //region Helper methods
    /**
     * Bind a model to the interface in the container.
     *
     * @param string $interfaceClass The interface class to bind.
     * @param string $modelClass The model class to bind.
     * @return void
     */
    protected function bindModel(string $interfaceClass, string $modelClass): void
    {
        app()->bind($interfaceClass, $modelClass);
    }

    /**
     * Guess the contract class for a given model class.
     *
     * @param string $modelClass The model class to guess the contract for.
     * @return string The guessed contract class name.
     */
    protected function guessContractClass(string $modelClass): string
    {
        $class = new \ReflectionClass($modelClass);

        $shortName = $class->getShortName();
        $namespace = $class->getNamespaceName();

        return "{$namespace}\\Contracts\\$shortName";
    }

    /**
     * Guess the model class for a given contract.
     *
     * @param string $modelContract The model contract to guess the class for.
     * @return string The guessed model class name.
     */
    protected function guessModelClass(string $modelContract): string
    {
        $shortName = (new \ReflectionClass($modelContract))->getShortName();

        return 'SolutionForest\\FilamentFieldGroup\\Models\\'.$shortName;
    }

    /**
     * Validate that a class is an Eloquent model.
     *
     * @param string $class The class to validate.
     * @throws \InvalidArgumentException If the class is not a subclass of Model.
     * @return void
     */
    private function validateClassIsEloquentModel(string $class): void
    {
        if (! is_subclass_of($class, Model::class)) {
            throw new \InvalidArgumentException(sprintf('Given [%s] is not a subclass of [%s].', $class, Model::class));
        }
    }
    //endregion Helper methods
}