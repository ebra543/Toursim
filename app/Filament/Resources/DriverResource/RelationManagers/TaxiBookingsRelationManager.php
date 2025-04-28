<?php

namespace App\Filament\Resources\DriverResource\RelationManagers;

use App\Models\TaxiBooking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaxiBookingsRelationManager extends RelationManager
{
    protected static string $relationship = 'taxiBookings';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('PickupDateTime')
                    ->required(),
                Forms\Components\TextInput::make('EstimatedDistance')
                    ->required()
                    ->numeric()
                    ->step(0.01),
                Forms\Components\Select::make('PickupLocationID')
                    ->relationship('pickupLocation', 'Address')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('DropoffLocationID')
                    ->relationship('dropoffLocation', 'Address')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('VehicleTypeID')
                    ->relationship('vehicleType', 'TypeName')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('VehicleID')
                    ->relationship('vehicle', 'RegistrationNumber')
                    ->searchable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('TaxiBookingID')
            ->columns([
                Tables\Columns\TextColumn::make('booking.BookingReference')
                    ->label('Booking Reference')
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
                Tables\Columns\TextColumn::make('vehicle.RegistrationNumber')
                    ->label('Vehicle')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('upcoming')
                    ->query(fn (Builder $query): Builder => $query->where('PickupDateTime', '>', now())),
                Tables\Filters\Filter::make('past')
                    ->query(fn (Builder $query): Builder => $query->where('PickupDateTime', '<', now())),
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
