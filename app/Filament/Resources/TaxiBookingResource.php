<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaxiBookingResource\Pages;
use App\Filament\Resources\TaxiBookingResource\RelationManagers;
use App\Models\TaxiBooking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaxiBookingResource extends Resource
{
    protected static ?string $model = TaxiBooking::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Taxi Management';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Booking Information')
                    ->schema([
                        Forms\Components\Select::make('BookingID')
                            ->relationship('booking', 'BookingReference')
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('TaxiServiceID')
                            ->relationship('taxiService', 'ServiceName')
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('VehicleTypeID')
                            ->relationship('vehicleType', 'TypeName')
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('PickupLocationID')
                            ->relationship('pickupLocation', 'Address')
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('DropoffLocationID')
                            ->relationship('dropoffLocation', 'Address')
                            ->searchable()
                            ->required(),
                        Forms\Components\DateTimePicker::make('PickupDateTime')
                            ->required(),
                        Forms\Components\TextInput::make('EstimatedDistance')
                            ->required()
                            ->numeric()
                            ->step(0.01),
                        Forms\Components\Select::make('DriverID')
                            ->relationship('driver', 'LicenseNumber')
                            ->searchable(),
                        Forms\Components\Select::make('VehicleID')
                            ->relationship('vehicle', 'RegistrationNumber')
                            ->searchable(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('booking.BookingReference')
                    ->label('Booking Reference')
                    ->searchable(),
                Tables\Columns\TextColumn::make('taxiService.ServiceName')
                    ->label('Taxi Service')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pickupLocation.Address')
                    ->label('Pickup Location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dropoffLocation.Address')
                    ->label('Dropoff Location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('PickupDateTime')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('EstimatedDistance')
                    ->suffix(' km')
                    ->sortable(),
                Tables\Columns\TextColumn::make('driver.LicenseNumber')
                    ->label('Driver')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vehicle.RegistrationNumber')
                    ->label('Vehicle')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('TaxiServiceID')
                    ->label('Taxi Service')
                    ->relationship('taxiService', 'ServiceName'),
                Tables\Filters\SelectFilter::make('VehicleTypeID')
                    ->label('Vehicle Type')
                    ->relationship('vehicleType', 'TypeName'),
                Tables\Filters\Filter::make('upcoming')
                    ->query(fn (Builder $query): Builder => $query->where('PickupDateTime', '>', now())),
                Tables\Filters\Filter::make('past')
                    ->query(fn (Builder $query): Builder => $query->where('PickupDateTime', '<', now())),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTaxiBookings::route('/'),
            'create' => Pages\CreateTaxiBooking::route('/create'),
            'view' => Pages\ViewTaxiBooking::route('/{record}'),
            'edit' => Pages\EditTaxiBooking::route('/{record}/edit'),
        ];
    }
}
