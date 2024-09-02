<?php

namespace SolutionForest\FilamentFieldGroup\Base\Manifests;

interface ModelManifestInterface
{
    /**
     * Bind initial models to the container and establish explicit model bindings.
     * @return void
     */
    public function register(): void;

    /**
     * Register models.
     *
     * @param string $interfaceClass The interface class to register.
     * @param string $modelClass The model class to register.
     * @return void
     */
    public function add(string $interfaceClass, string $modelClass): void;

    /**
     * Replace a model with a different implementation.
     *
     * @param string $interfaceClass The interface class to replace.
     * @param string $modelClass The new model class to use.
     * @return void
     */
    public function replace(string $interfaceClass, string $modelClass): void;

    /**
     * Gets the registered class for the interface.
     *
     * @param string $interfaceClass The interface class to retrieve.
     * @param string|null $fallback Optional fallback class if not found.
     * @return string|null The registered model class or fallback.
     */
    public function get(string $interfaceClass, ?string $fallback = null): ?string;
}