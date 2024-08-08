<?php

namespace SolutionForest\FilamentFieldGroup\Filament\Resources\FieldGroupResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use SolutionForest\FilamentFieldGroup\Facades\FilamentFieldGroup;

class FieldsRelationManager extends RelationManager
{
    protected static string $relationship = 'fields';

    public function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([

                Forms\Components\Section::make(__('filament-field-group::filament-field-group.general'))
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label(__('filament-field-group::filament-field-group.forms.fields.type.label'))
                            ->helperText(__('filament-field-group::filament-field-group.forms.fields.type.helper'))
                            ->options(FilamentFieldGroup::getFieldTypeGroupedKeyValueOptions())
                            ->searchable()
                            ->required()
                            ->columnSpan('full')
                            ->live(debounce: 500)
                            ->afterStateUpdated(fn (Forms\Components\Select $component) => $component
                                ->getContainer()
                                ->getParentComponent()->getContainer() // section
                                ->getComponent('configFields')
                                ?->getChildComponentContainer()
                                ?->fill()),
                        Forms\Components\TextInput::make('label')
                            ->label(__('filament-field-group::filament-field-group.forms.fields.label.label'))
                            ->helperText(__('filament-field-group::filament-field-group.forms.fields.label.helper'))
                            ->required()
                            ->columnSpan('full')
                            ->maxLength(255)
                            ->live(debounce: 500)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('name', Str::slug($state, '_'))),
                        Forms\Components\TextInput::make('name')
                            ->label(__('filament-field-group::filament-field-group.forms.fields.name.label'))
                            ->helperText(__('filament-field-group::filament-field-group.forms.fields.name.helper'))
                            ->required()
                            ->maxLength(255)
                            ->live(debounce: 500)
                            ->afterStateUpdated(fn ($component, ?string $state) => $component->state(Str::slug($state, '_')))
                            ->unique(ignoreRecord: true, modifyRuleUsing: function ($rule) {
                                return $rule->where('group_id', $this->getOwnerRecord()->getKey());
                            }),
                        Forms\Components\TextInput::make('state_path')
                            ->label(__('filament-field-group::filament-field-group.forms.fields.state_path.label'))
                            ->helperText(__('filament-field-group::filament-field-group.forms.fields.state_path.helper'))
                            ->maxLength(255),
                        Forms\Components\Toggle::make('mandatory')
                            ->label(__('filament-field-group::filament-field-group.forms.fields.mandatory.label'))
                            ->helperText(__('filament-field-group::filament-field-group.forms.fields.mandatory.helper'))
                            ->columnSpan('full')
                            ->inlineLabel(),
                        Forms\Components\TextInput::make('instructions')
                            ->label(__('filament-field-group::filament-field-group.forms.fields.instructions.label'))
                            ->helperText(__('filament-field-group::filament-field-group.forms.fields.instructions.helper'))
                            ->maxLength(255)
                            ->columnSpan('full'),
                    ]),
                Forms\Components\Section::make(__('filament-field-group::filament-field-group.config'))
                    ->key('configFields')
                    ->statePath('config')
                    ->collapsible()
                    ->schema(function (Forms\Get $get) {

                        if ($get('type')) {
                            return FilamentFieldGroup::getFieldTypeConfigFormSchema($get('type'));
                        }

                        return [];
                    }),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->reorderable('sort')
            ->defaultSort('sort')
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('sort')
                    ->label(__('filament-field-group::filament-field-group.sort'))
                    ->sortable()->width('1%'),
                Tables\Columns\TextColumn::make('id')
                    ->label(__('filament-field-group::filament-field-group.id'))
                    ->sortable()->width('1%'),
                Tables\Columns\TextColumn::make('label')
                    ->label(__('filament-field-group::filament-field-group.tables.fields.label')),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament-field-group::filament-field-group.tables.fields.name'))
                    ->badge(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('filament-field-group::filament-field-group.tables.fields.type'))
                    ->formatStateUsing(fn ($state) => FilamentFieldGroup::getFieldTypeDisplayValue($state)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
