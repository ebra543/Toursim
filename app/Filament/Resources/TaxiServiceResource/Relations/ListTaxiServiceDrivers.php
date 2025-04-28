<?php

namespace App\Filament\Resources\TaxiServiceResource\Relations;

use App\Models\Driver;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ListTaxiServiceDrivers extends RelationManager
{
    protected static string $relationship = 'drivers';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('LicenseNumber')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ExperienceYears')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('Rating')
                    ->numeric()
                    ->default(0)
                    ->maxValue(5)
                    ->minValue(0)
                    ->step(0.1),
                Forms\Components\Toggle::make('IsActive')
                    ->required()
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('LicenseNumber')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Driver Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('LicenseNumber')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ExperienceYears')
                    ->sortable(),
                Tables\Columns\TextColumn::make('Rating')
                    ->sortable(),
                Tables\Columns\IconColumn::make('IsActive')
                    ->boolean(),
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
