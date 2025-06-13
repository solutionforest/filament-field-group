<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs;

use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Contracts\FieldTypeConfig;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Concerns\HasAffixes;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Concerns\HasDefaultValue;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Concerns\HasPlaceholder;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Concerns\HasRules;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Filament\Forms;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\ConfigName;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\DbType;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\FormComponent;

#[ConfigName('dateTimePicker', 'DateTime Picker', 'Picker', 'heroicon-o-calendar-date-range')]
#[FormComponent(Forms\Components\DateTimePicker::class)]
#[DbType('mysql', 'varchar')]
#[DbType('sqlite', 'text')]
class DateTimePicker extends FieldTypeBaseConfig implements FieldTypeConfig
{
    use HasAffixes;
    use HasDefaultValue;
    use HasPlaceholder;
    use HasRules;

    public bool $hasTime = true;

    public bool $hasDate = true;

    public ?string $format = null;

    public ?string $displayFormat = null;

    public bool $isNative = true;

    public function getFormSchema(): array
    {
        return [
            Tabs::make('tabs')
                ->tabs([
                    Tab::make('Validation')
                        ->schema([
                            static::getHasRulesFormComponent('rule'),
                            TextInput::make('format')
                                ->hint('Custom the storage format.')
                                ->placeholder('Y-m-d H:i:s')
                                ->helperText(str('The format used to store the date in the database. More info <a href="https://filamentphp.com/docs/3.x/forms/fields/date-time-picker#customizing-the-storage-format"><u><b>here</b></u></a>.')->toHtmlString()),
                        ]),
                    Tab::make('Presentation')
                        ->schema([
                            static::getHasDefaultValueFormComponent('defaultValue'),
                            static::getHasPlaceholderFormComponent('placeholder'),
                            static::getHasAffixesFormComponent('prefixLabel'),
                            static::getHasAffixesFormComponent('suffixLabel'),

                            Toggle::make('hasTime')->inlineLabel()->default(true),
                            Toggle::make('hasDate')->inlineLabel()->default(true),
                            TextInput::make('displayFormat')
                                ->hint('Custom the display format.')
                                ->placeholder('d F Y')
                                ->helperText(str('The format used to display the date in the form. More info <a href="https://filamentphp.com/docs/3.x/forms/fields/date-time-picker#customizing-the-display-format"><u><b>here</b></u></a>.')->toHtmlString()),

                            Toggle::make('isNative')->inlineLabel()->default(true),
                        ]),
                ]),
        ];
    }

    public function applyConfig(Component $component): void
    {
        if ($this->defaultValue != null) {
            $component->default($this->defaultValue);
        }

        if ($component instanceof Forms\Components\DateTimePicker) {
            $component->date($this->hasDate);
            $component->time($this->hasTime);

            if ($this->format) {
                $component->format($this->format);
            }

            if ($this->displayFormat) {
                $component->displayFormat($this->displayFormat);
            }

            $component->native($this->isNative);
        }
    }
}
