<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleTypeResource\Pages;
use App\Filament\Resources\VehicleTypeResource\Relations;
use App\Models\VehicleType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VehicleTypeResource extends Resource
{
    protected static ?string $model = VehicleType::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Taxi Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Vehicle Type Information')
                    ->schema([
                        Forms\Components\Select::make('TaxiServiceID')
                            ->label('Taxi Service')
                            ->relationship('taxiService', 'ServiceName')
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('TypeName')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('Description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('MaxPassengers')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->default(4),
                        Forms\Components\TextInput::make('PricePerKm')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->step(0.01),
                        Forms\Components\TextInput::make('BasePrice')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->step(0.01),
                        Forms\Components\TextInput::make('ImageURL')
                            ->label('Image URL')
                            ->url()
                            ->maxLength(255),
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
                Tables\Columns\TextColumn::make('TypeName')
                    ->searchable(),
                Tables\Columns\TextColumn::make('MaxPassengers')
                    ->sortable(),
                Tables\Columns\TextColumn::make('PricePerKm')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('BasePrice')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\IconColumn::make('IsActive')
                    ->boolean()
                    ->label('Active'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('TaxiServiceID')
                    ->label('Taxi Service')
                    ->relationship('taxiService', 'ServiceName'),
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
            Relations\ListVehicleTypeVehicles::make(),
            Relations\ListVehicleTypeTaxiBookings::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVehicleTypes::route('/'),
            'create' => Pages\CreateVehicleType::route('/create'),
            'view' => Pages\ViewVehicleType::route('/{record}'),
            'edit' => Pages\EditVehicleType::route('/{record}/edit'),
        ];
    }
}
