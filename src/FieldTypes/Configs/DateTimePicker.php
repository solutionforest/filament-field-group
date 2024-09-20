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

    public ?string $displatFormat = null;

    public bool $isNative = true;

    public function getFormSchema(): array
    {
        return [
            Forms\Components\Tabs::make('tabs')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('Validation')
                        ->schema([
                            static::getHasRulesFormComponent('rule'),
                            Forms\Components\TextInput::make('format'),
                        ]),
                    Forms\Components\Tabs\Tab::make('Presentation')
                        ->schema([
                            static::getHasDefaultValueFormComponent('defaultValue'),
                            static::getHasPlaceholderFormComponent('placeholder'),
                            static::getHasAffixesFormComponent('prefixLabel'),
                            static::getHasAffixesFormComponent('suffixLabel'),

                            Forms\Components\Toggle::make('hasTime')->inlineLabel()->default(true),
                            Forms\Components\Toggle::make('hasDate')->inlineLabel()->default(true),
                            Forms\Components\TextInput::make('displatFormat'),

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

            if ($this->displatFormat) {
                $component->displatFormat($this->displatFormat);
            }

            $component->native($this->isNative);
        }
    }
}
