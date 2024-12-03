<?php

namespace SolutionForest\FilamentFieldGroup\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;
use SolutionForest\FilamentFieldGroup\FilamentFieldGroupServiceProvider;
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

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $migration = include __DIR__ . '/../database/migrations/create_advanced_fields_table.php.stub';
        $migration->up();
    }

    /**
     * Builds a form component for the specified field type.
     *
     * @param  \SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts\FieldTypeConfig  $fieldType  The type of the field for which the form component is to be built.
     * @return array{0: \Filament\Forms\Components\Component, 1: \Filament\Forms\Components\Component}
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

        $component = $fieldGroup->toFilamentComponent();

        return [
            $component,
            $component->getChildComponents()[0],
        ];
    }
}
