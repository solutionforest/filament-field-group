<?php

namespace SolutionForest\FilamentFieldGroup\Facades;

use Illuminate\Support\Facades\Facade;
use SolutionForest\FilamentFieldGroup\Base\Manifests\ModelManifestInterface;

/**
 * @method static void register()
 * @method static void add(string $interfaceClass, string $modelClass)
 * @method static void replace(string $interfaceClass, string $modelClass)
 * @method static ?string get(string $interfaceClass, ?string $fallback = null)
 * 
 * @see \SolutionForest\FilamentFieldGroup\Base\Manifests\ModelManifest
 */
class ModelManifest extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return ModelManifestInterface::class;
    }
}