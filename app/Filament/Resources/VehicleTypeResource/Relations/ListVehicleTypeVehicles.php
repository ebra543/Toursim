<?php

namespace App\Filament\Resources\VehicleTypeResource\Relations;

use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ListVehicleTypeVehicles extends RelationManager
{
    protected static string $relationship = 'vehicles';

    protected static ?string $recordTitleAttribute = 'RegistrationNumber';

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
                    ->numeric()
                    ->minValue(1900)
                    ->maxValue(date('Y') + 1),
                Forms\Components\TextInput::make('Color')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('IsAvailable')
                    ->label('Available')
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('RegistrationNumber')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Year')
                    ->sortable(),
                Tables\Columns\TextColumn::make('Color'),
                Tables\Columns\IconColumn::make('IsAvailable')
                    ->boolean()
                    ->label('Available'),
                Tables\Columns\TextColumn::make('driver.FullName')
                    ->label('Driver')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('IsAvailable')
                    ->options([
                        '1' => 'Available',
                        '0' => 'Not Available',
                    ])
                    ->label('Availability'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
