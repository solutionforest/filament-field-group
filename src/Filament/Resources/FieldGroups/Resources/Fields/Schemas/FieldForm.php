<?php

namespace SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroups\Resources\Fields\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use SolutionForest\FilamentFieldGroup\Facades\FilamentFieldGroup;

class FieldForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make(__('filament-field-group::filament-field-group.general'))
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        Select::make('type')
                            ->label(__('filament-field-group::filament-field-group.forms.fields.type.label'))
                            ->helperText(__('filament-field-group::filament-field-group.forms.fields.type.helper'))
                            ->options(fn () => FilamentFieldGroup::getFieldTypeGroupedKeyValueWithIconOptions())
                            ->getSearchResultsUsing(fn ($search) => FilamentFieldGroup::getFieldTypeGroupedKeyValueWithIconOptions($search))
                            ->searchable()
                            ->allowHtml()
                            ->required()
                            ->columnSpan('full')
                            ->live(debounce: 500)
                            ->afterStateUpdated(fn (Select $component) => $component
                                ->getContainer()
                                ->getParentComponent()->getContainer() // section
                                // ->getComponent('configFields')
                                ->getComponent(
                                    'form.configFields',
                                    withHidden: true,
                                    isAbsoluteKey: true,
                                )
                                ?->getChildSchema()
                                ?->fill()),
                        TextInput::make('label')
                            ->label(__('filament-field-group::filament-field-group.forms.fields.label.label'))
                            ->helperText(__('filament-field-group::filament-field-group.forms.fields.label.helper'))
                            ->required()
                            ->columnSpan('full')
                            ->maxLength(255)
                            ->live(debounce: 500)
                            ->afterStateUpdated(fn ($set, ?string $state) => $set('name', Str::slug($state, '_'))),
                        TextInput::make('name')
                            ->label(__('filament-field-group::filament-field-group.forms.fields.name.label'))
                            ->helperText(__('filament-field-group::filament-field-group.forms.fields.name.helper'))
                            ->required()
                            ->maxLength(255)
                            ->live(debounce: 500)
                            ->afterStateUpdated(fn ($component, ?string $state) => $component->state(Str::slug($state, '_')))
                            ->unique(ignoreRecord: true, modifyRuleUsing: function ($rule, Page $livewire) {
                                return $rule->where('group_id', $livewire->getParentRecord()?->getKey());
                            }),
                        TextInput::make('state_path')
                            ->label(__('filament-field-group::filament-field-group.forms.fields.state_path.label'))
                            ->helperText(__('filament-field-group::filament-field-group.forms.fields.state_path.helper'))
                            ->maxLength(255),
                        Toggle::make('mandatory')
                            ->label(__('filament-field-group::filament-field-group.forms.fields.mandatory.label'))
                            ->helperText(__('filament-field-group::filament-field-group.forms.fields.mandatory.helper'))
                            ->columnSpan('full')
                            ->inlineLabel(),
                        TextInput::make('instructions')
                            ->label(__('filament-field-group::filament-field-group.forms.fields.instructions.label'))
                            ->helperText(__('filament-field-group::filament-field-group.forms.fields.instructions.helper'))
                            ->maxLength(255)
                            ->columnSpan('full'),
                    ]),
                Section::make(__('filament-field-group::filament-field-group.config'))
                    ->key('configFields')
                    ->statePath('config')
                    ->collapsible()
                    ->schema(function (Get $get) {

                        $type = data_get($get('./'), 'type');

                        if ($type) {
                            return FilamentFieldGroup::getFieldTypeConfigFormSchema($type);
                        }

                        return [];
                    }),
            ]);
    }
}
