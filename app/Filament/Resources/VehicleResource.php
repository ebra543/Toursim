<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleResource\Pages;
use App\Filament\Resources\VehicleResource\Relations;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = 'Taxi Management';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Vehicle Information')
                    ->schema([
                        Forms\Components\Select::make('TaxiServiceID')
                            ->label('Taxi Service')
                            ->relationship('taxiService', 'ServiceName')
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('VehicleTypeID')
                            ->label('Vehicle Type')
                            ->relationship('vehicleType', 'TypeName')
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('RegistrationNumber')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\TextInput::make('Model')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('Year')
                            ->required()
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(date('Y') + 1),
                        Forms\Components\TextInput::make('Color')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\Toggle::make('IsActive')
                            ->label('Active')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('taxiService.ServiceName')
                    ->label('Taxi Service')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vehicleType.TypeName')
                    ->label('Vehicle Type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('RegistrationNumber')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Year')
                    ->sortable(),
                Tables\Columns\TextColumn::make('Color')
                    ->searchable(),
                Tables\Columns\IconColumn::make('IsActive')
                    ->boolean()
                    ->label('Active'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('TaxiServiceID')
                    ->label('Taxi Service')
                    ->relationship('taxiService', 'ServiceName'),
                Tables\Filters\SelectFilter::make('VehicleTypeID')
                    ->label('Vehicle Type')
                    ->relationship('vehicleType', 'TypeName'),
                Tables\Filters\SelectFilter::make('IsActive')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ])
                    ->label('Status'),
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

    public static function getRelations(): array
    {
        return [
            Relations\TaxiBookingsRelationManager::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'view' => Pages\ViewVehicle::route('/{record}'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }
}
