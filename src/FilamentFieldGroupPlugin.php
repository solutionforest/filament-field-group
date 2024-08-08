<?php

namespace SolutionForest\FilamentFieldGroup;

use Filament\Contracts\Plugin;
use Filament\Panel;
use SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroupResource;

class FilamentFieldGroupPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-field-group';
    }

    public function register(Panel $panel): void
    {
        // Register the FieldGroup resource
        if (config('filament-field-group.enabled', false)) {
            $panel->resources([
                FieldGroupResource::class,
            ]);
        }
    }

    public function boot(Panel $panel): void {}

    protected function registerCustomFields(): void {}

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
}
