<?php

namespace SolutionForest\FilamentFieldGroup\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts\FieldTypeConfig;
use SolutionForest\FilamentFieldGroup\FilamentFieldGroupServiceProvider;
use SolutionForest\FilamentFieldGroup\Tests\Fixtures\Livewire\Livewire;
use SolutionForest\FilamentFieldGroup\Tests\Support\TestModels\Field;
use SolutionForest\FilamentFieldGroup\Tests\Support\TestModels\FieldGroup;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'SolutionForest\\FilamentFieldGroup\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
        Factory::guessModelNamesUsing(
            fn ($factory) => 'SolutionForest\\FilamentFieldGroup\\Tests\\Support\\TestModels\\' . str_replace('Factory', '', class_basename($factory))
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            ActionsServiceProvider::class,
            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            InfolistsServiceProvider::class,
            LivewireServiceProvider::class,
            NotificationsServiceProvider::class,
            SupportServiceProvider::class,
            TablesServiceProvider::class,
            WidgetsServiceProvider::class,
            FilamentFieldGroupServiceProvider::class,
        ];
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/*.php.stub');
    }

    protected function loadMigrationsFrom($paths): void
    {
        // Stub files
        if (is_string($paths) && str($paths)->endsWith(['*.php', '*.php.stub'])) {
            $migrationPath = realpath(str($paths)->beforeLast('/'));
            $filePattern = (string) str($paths)->afterLast('/');

            foreach (glob("{$migrationPath}/{$filePattern}") as $path) {

                $migration = include $path;
                $migration->up();
            }
        } else {
            parent::loadMigrationsFrom($paths);
        }
    }

    /**
     * Builds a form component for the specified field type.
     *
     * @param  FieldTypeConfig  $fieldType  The type of the field for which the form component is to be built.
     * @return array{0: Component, 1:?Component}
     */
    protected function buildFormComponentForFieldType($fieldType)
    {
        $fieldTypeConfig = ($fieldType->getConfigNames()[0] ?? []);
        $config = (array) $fieldType;

        $fieldGroup = FieldGroup::factory()
            ->has(
                Field::factory([
                    'type' => $fieldTypeConfig['name'],
                    'config' => $config,
                ]),
                'fields'
            )
            ->create();

        $fieldGroup->loadMissing('fields');

        $component = $fieldGroup
            ->toFilamentComponent()
            ->container(Schema::make(Livewire::make()));

        return [
            $component,
            Arr::first($component->getChildComponents()),
        ];
    }
}
