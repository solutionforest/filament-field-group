<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Filament\Forms;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Forms\Components\Concerns\CanBeValidated;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use League\Flysystem\UnableToCheckFileExistence;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\ConfigName;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\DbType;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\FormComponent;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Concerns\HasRules;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts\FieldTypeConfig;

#[ConfigName('file', 'File', 'Content', 'heroicon-o-cloud-arrow-up')]
#[FormComponent(FileUpload::class)]
#[DbType('mysql', 'varchar')]
#[DbType('sqlite', 'text')]
class File extends FieldTypeBaseConfig implements FieldTypeConfig
{
    use HasRules;

    public ?string $disk = null;

    public ?string $directory = null;

    public bool $visibility = true;

    public bool $multiple = false;

    public array $acceptedFileTypes = [];

    public array $sizeLimit = [];

    public array $fileLimit = [];

    public function getFormSchema(): array
    {
        return [
            Tabs::make('tabs')
                ->tabs([
                    Tab::make('Validation')
                        ->schema([
                            static::getHasRulesFormComponent('rule'),
                            Repeater::make('acceptedFileTypes')
                                ->defaultItems(0)
                                ->simple(
                                    TextInput::make('type')
                                        ->placeholder('e.g. image/*')
                                ),
                            Grid::make(2)
                                ->statePath('fileLimit')
                                ->schema([
                                    TextInput::make('min')
                                        ->integer(),
                                    TextInput::make('max')
                                        ->integer(),
                                ]),
                            Grid::make(2)
                                ->statePath('sizeLimit')
                                ->schema([
                                    TextInput::make('min')
                                        ->integer()
                                        ->suffix('KB'),
                                    TextInput::make('max')
                                        ->integer()
                                        ->suffix('KB'),
                                ]),
                        ]),
                    Tab::make('Presentation')
                        ->schema([
                            TextInput::make('disk')
                                ->default(config('filesystems.default'))
                                ->required(),
                            TextInput::make('directory'),
                            Toggle::make('visibility')
                                ->inlineLabel()
                                ->default(false),
                            Toggle::make('multiple')
                                ->inlineLabel()
                                ->default(false),
                        ]),
                ]),
        ];
    }

    public function applyConfig(Component $component): void
    {
        $component
            ->visibility($this->visibility ? 'public' : 'private');

        if (static::fiComponentHasTrait($component, CanBeValidated::class)) {
            if ($this->rule) {
                $component->rule($this->rule);
            }
        }

        if ($this->disk !== null) {
            $component->disk($this->disk);
        }

        if ($this->directory !== null) {
            $component->directory($this->directory);
        }

        if (! empty($this->acceptedFileTypes)) {
            $component->acceptedFileTypes(array_filter($this->acceptedFileTypes));
        }

        if (! empty($this->sizeLimit)) {
            if (isset($this->sizeLimit['min']) && $this->sizeLimit['min'] > 0) {
                $component->minSize(intval($this->sizeLimit['min']));
            }
            if (isset($this->sizeLimit['max']) && $this->sizeLimit['max'] > 0) {
                $component->maxSize(intval($this->sizeLimit['max']));
            }
        }

        if (! empty($this->fileLimit)) {
            if (isset($this->fileLimit['min']) && $this->fileLimit['min'] > 0) {
                $component->minFiles(intval($this->fileLimit['min']));
                $this->multiple = true;
            }
            if (isset($this->fileLimit['max']) && $this->fileLimit['max'] > 0) {
                $component->maxFiles(intval($this->fileLimit['max']));
                $this->multiple = true;
            }
        }

        if ($this->multiple) {
            $component->multiple();
        }

        $component->afterStateHydrated(function ($component, $state) {

            if (is_null($state)) {
                $component->state([]);

                return;
            }

            $shouldFetchFileInformation = $component->shouldFetchFileInformation();

            $files = collect(Arr::wrap($state))
                ->filter(static function (string $file) use ($component, $shouldFetchFileInformation): bool {
                    if (blank($file)) {
                        return false;
                    }

                    if (! $shouldFetchFileInformation) {
                        return true;
                    }

                    try {
                        return $component->getDisk()->exists($file);
                    } catch (UnableToCheckFileExistence $exception) {
                        return false;
                    }
                })
                ->mapWithKeys(static fn (string $file): array => [((string) Str::uuid()) => $file])
                ->all();

            $component->state($files);
        });

        $component->dehydrateStateUsing(static function (BaseFileUpload $component): string | array | null {

            $component->saveUploadedFiles();

            $state = $component->getState();

            $files = array_values($state ?? []);

            if ($component->isMultiple()) {
                return $files;
            }

            return $files[0] ?? null;
        });
    }
}
