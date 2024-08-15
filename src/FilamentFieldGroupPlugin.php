<?php

namespace SolutionForest\FilamentFieldGroup;

use Filament\Contracts\Plugin;
use Filament\Panel;
use SolutionForest\FilamentFieldGroup\Concerns\HasFieldTypes;
use SolutionForest\FilamentFieldGroup\Concerns\HasFilamentResources;

class FilamentFieldGroupPlugin implements Plugin
{
    use HasFieldTypes;
    use HasFilamentResources;

    protected bool $enablePlugin = false;

    public function getId(): string
    {
        return 'filament-field-group';
    }

    public function register(Panel $panel): void
    {
        // Register the FieldGroup resource
        if ($this->isEnabled()) {
            $panel->resources($this->getFilamentResources());
        }
    }

    public function boot(Panel $panel): void {}

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    public function enablePlugin(bool $enable = true): static
    {
        $this->enablePlugin = $enable;

        return $this;
    }

    public function isEnabled(): bool
    {
        if ($this->enablePlugin) {
            return true;
        }

        return config('filament-field-group.enabled', false);
    }
}
