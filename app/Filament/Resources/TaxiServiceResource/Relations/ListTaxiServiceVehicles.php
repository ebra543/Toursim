<?php

namespace App\Filament\Resources\TaxiServiceResource\Relations;

use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ListTaxiServiceVehicles extends RelationManager
{
    protected static string $relationship = 'vehicles';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('RegistrationNumber')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('Model')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('Year')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('Color')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('IsActive')
                    ->required()
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('RegistrationNumber')
            ->columns([
                Tables\Columns\TextColumn::make('RegistrationNumber')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Year')
                    ->sortable(),
                Tables\Columns\TextColumn::make('Color'),
                Tables\Columns\IconColumn::make('IsActive')
                    ->boolean(),
                Tables\Columns\TextColumn::make('vehicleType.TypeName')
                    ->label('Vehicle Type'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
