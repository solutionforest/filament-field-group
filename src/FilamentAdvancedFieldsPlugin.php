<?php

namespace Solutionforest\FilamentAdvancedFields;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\Support\Facades\Blade;
use Solutionforest\FilamentAdvancedFields\Filament\Resources\FieldGroupResource;
use Solutionforest\FilamentAdvancedFields\Models\FieldGroup;

class FilamentAdvancedFieldsPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-advanced-fields';
    }

    public function register(Panel $panel): void
    {
        // Register the FieldGroup resource
        $panel->resources([
            FieldGroupResource::class,
        ]);

        // Register custom field types
        // $this->registerCustomFields();

        // Register config
        // $this->mergeConfigFrom(__DIR__.'/../config/filament-advanced-fields.php', 'filament-advanced-fields');
    }

    public function boot(Panel $panel): void
    {
        // // Load migrations
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // // Load views
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-advanced-fields');

        // // Register Blade components
        // Blade::componentNamespace('Solutionforest\\FilamentAdvancedFields\\View\\Components', 'filament-advanced-fields');
    }

    protected function registerCustomFields(): void
    {
        $this->app->bind('advanced-fields.text', function () {
            return new Fields\TextField;
        });
    }

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
