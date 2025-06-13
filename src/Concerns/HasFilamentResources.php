<?php

namespace SolutionForest\FilamentFieldGroup\Concerns;

use SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\FieldGroupResource;
use SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Resources\Fields\FieldResource;

trait HasFilamentResources
{
    protected array $resources = [
        FieldGroupResource::class,
        FieldResource::class,
    ];

    public function resources(array $resources, bool $override = true): static
    {
        if ($override) {
            $this->resources = $resources;
        } else {
            $this->resources = array_merge($this->resources, $resources);
        }

        return $this;
    }

    public function overrideResources(array $resources): static
    {
        return $this->resources($resources);
    }

    public function getFilamentResources(): array
    {
        return $this->resources;
    }
}
