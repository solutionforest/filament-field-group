<?php

namespace SolutionForest\FilamentFieldGroup\FieldTypes\Configs;

use Filament\Forms;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\ConfigName;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\DbType;
use SolutionForest\FilamentFieldGroup\FieldTypes\Configs\Attributes\FormComponent;

#[ConfigName('dateTimePicker', 'DateTime Picker', 'Picker', 'heroicon-o-calendar-date-range')]
#[FormComponent(Forms\Components\DateTimePicker::class)]
#[DbType('mysql', 'varchar')]
#[DbType('sqlite', 'text')]
class DateTimePicker extends FieldTypeBaseConfig implements Contracts\FieldTypeConfig
{
    use Concerns\HasAffixes;
    use Concerns\HasDefaultValue;
    use Concerns\HasPlaceholder;
    use Concerns\HasRules;

    public bool $hasTime = true;

    public bool $hasDate = true;

    public ?string $format = null;

    public ?string $displayFormat = null;

    public bool $isNative = true;

    public function getFormSchema(): array
    {
        return [
            Forms\Components\Tabs::make('tabs')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('Validation')
                        ->schema([
                            static::getHasRulesFormComponent('rule'),
                            Forms\Components\TextInput::make('format')
                                ->hint('Custom the storage format.')
                                ->placeholder('Y-m-d H:i:s')
                                ->helperText(str('The format used to store the date in the database. More info <a href="https://filamentphp.com/docs/3.x/forms/fields/date-time-picker#customizing-the-storage-format"><u><b>here</b></u></a>.')->toHtmlString()),
                        ]),
                    Forms\Components\Tabs\Tab::make('Presentation')
                        ->schema([
                            static::getHasDefaultValueFormComponent('defaultValue'),
                            static::getHasPlaceholderFormComponent('placeholder'),
                            static::getHasAffixesFormComponent('prefixLabel'),
                            static::getHasAffixesFormComponent('suffixLabel'),

                            Forms\Components\Toggle::make('hasTime')->inlineLabel()->default(true),
                            Forms\Components\Toggle::make('hasDate')->inlineLabel()->default(true),
                            Forms\Components\TextInput::make('displayFormat')
                                ->hint('Custom the display format.')
                                ->placeholder('d F Y')
                                ->helperText(str('The format used to display the date in the form. More info <a href="https://filamentphp.com/docs/3.x/forms/fields/date-time-picker#customizing-the-display-format"><u><b>here</b></u></a>.')->toHtmlString()),

                            Forms\Components\Toggle::make('isNative')->inlineLabel()->default(true),
                        ]),
                ]),
        ];
    }

    public function applyConfig(Forms\Components\Component $component): void
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
