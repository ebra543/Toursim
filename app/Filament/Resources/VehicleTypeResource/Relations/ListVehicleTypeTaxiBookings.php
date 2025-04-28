<?php

namespace App\Filament\Resources\VehicleTypeResource\Relations;

use App\Models\TaxiBooking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ListVehicleTypeTaxiBookings extends RelationManager
{
    protected static string $relationship = 'taxiBookings';

    protected static ?string $recordTitleAttribute = 'BookingReference';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('BookingReference')
                    ->required()
                    ->maxLength(255)
                    ->disabled(),
                Forms\Components\DateTimePicker::make('PickupDateTime')
                    ->required(),
                Forms\Components\TextInput::make('PickupLocation')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('DropoffLocation')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('EstimatedDistance')
                    ->numeric()
                    ->suffix('km')
                    ->minValue(0),
                Forms\Components\TextInput::make('TotalPrice')
                    ->numeric()
                    ->prefix('$')
                    ->disabled(),
                Forms\Components\Select::make('Status')
                    ->options([
                        'Pending' => 'Pending',
                        'Confirmed' => 'Confirmed',
                        'In Progress' => 'In Progress',
                        'Completed' => 'Completed',
                        'Cancelled' => 'Cancelled',
                    ])
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('BookingReference')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('PickupDateTime')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('PickupLocation')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('DropoffLocation')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('EstimatedDistance')
                    ->suffix(' km'),
                Tables\Columns\TextColumn::make('TotalPrice')
                    ->money('USD'),
                Tables\Columns\TextColumn::make('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pending' => 'gray',
                        'Confirmed' => 'info',
                        'In Progress' => 'warning',
                        'Completed' => 'success',
                        'Cancelled' => 'danger',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('Status')
                    ->options([
                        'Pending' => 'Pending',
                        'Confirmed' => 'Confirmed',
                        'In Progress' => 'In Progress',
                        'Completed' => 'Completed',
                        'Cancelled' => 'Cancelled',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
