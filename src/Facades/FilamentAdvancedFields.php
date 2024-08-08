<?php

namespace Solutionforest\FilamentAdvancedFields\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Solutionforest\FilamentAdvancedFields\FilamentAdvancedFields
 */
class FilamentAdvancedFields extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Solutionforest\FilamentAdvancedFields\FilamentAdvancedFields::class;
    }
}
