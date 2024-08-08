<?php

namespace Solutionforest\FilamentAdvancedFields\Filament\Resources;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Solutionforest\FilamentAdvancedFields\Filament\Resources\FieldGroupResource\Pages;
use Solutionforest\FilamentAdvancedFields\Models\FieldGroup;

class FieldGroupResource extends Resource
{
    protected static ?string $model = FieldGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('name')
                //     ->required()
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('location')
                //     ->maxLength(255),
                // Forms\Components\Toggle::make('active')
                //     ->required(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('name'),
                // Tables\Columns\TextColumn::make('location'),
                // Tables\Columns\BooleanColumn::make('active'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFieldGroup::route('/'),
            'create' => Pages\CreateFieldGroup::route('/create'),
            'edit' => Pages\EditFieldGroup::route('/{record}/edit'),
        ];
    }
}
