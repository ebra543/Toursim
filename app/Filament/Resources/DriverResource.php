<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DriverResource\Pages;
use App\Filament\Resources\DriverResource\RelationManagers;
use App\Models\Driver;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DriverResource extends Resource
{
    protected static ?string $model = Driver::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Taxi Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Driver Information')
                    ->schema([
                        Forms\Components\Select::make('UserID')
                            ->label('User')
                            ->relationship('user', 'Email')
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('TaxiServiceID')
                            ->label('Taxi Service')
                            ->relationship('taxiService', 'ServiceName')
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('LicenseNumber')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\TextInput::make('ExperienceYears')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(50),
                        Forms\Components\TextInput::make('Rating')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(5)
                            ->step(0.1),
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
                Tables\Columns\TextColumn::make('user.Email')
                    ->label('User Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('taxiService.ServiceName')
                    ->label('Taxi Service')
                    ->searchable(),
                Tables\Columns\TextColumn::make('LicenseNumber')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ExperienceYears')
                    ->sortable(),
                Tables\Columns\TextColumn::make('Rating')
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
            RelationManagers\TaxiBookingsRelationManager::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDrivers::route('/'),
            'create' => Pages\CreateDriver::route('/create'),
            'view' => Pages\ViewDriver::route('/{record}'),
            'edit' => Pages\EditDriver::route('/{record}/edit'),
        ];
    }
}
