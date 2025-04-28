<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaxiServiceResource\Pages;
use App\Filament\Resources\TaxiServiceResource\Relations;
use App\Models\TaxiService;
use App\Models\Location;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaxiServiceResource extends Resource
{
    protected static ?string $model = TaxiService::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = 'Taxi Management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Taxi Service Information')
                    ->schema([
                        Forms\Components\TextInput::make('ServiceName')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('Description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('LocationID')
                            ->label('Location')
                            ->options(Location::all()->pluck('Address', 'LocationID'))
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('AverageRating')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->maxValue(5)
                            ->minValue(0)
                            ->step(0.01),
                        Forms\Components\TextInput::make('TotalRatings')
                            ->numeric()
                            ->default(0)
                            ->disabled(),
                    ])->columns(2),
                Forms\Components\Section::make('Contact Information')
                    ->schema([
                        Forms\Components\TextInput::make('LogoURL')
                            ->label('Logo URL')
                            ->url()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('Website')
                            ->url()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('Phone')
                            ->tel()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('Email')
                            ->email()
                            ->maxLength(255),
                    ])->columns(2),
                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Toggle::make('IsActive')
                            ->label('Active')
                            ->default(true),
                        Forms\Components\Select::make('ManagerID')
                            ->label('Manager')
                            ->relationship('manager', 'name')
                            ->searchable(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ServiceName')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location.Address')
                    ->label('Location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('AverageRating')
                    ->sortable(),
                Tables\Columns\TextColumn::make('Phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Email')
                    ->searchable(),
                Tables\Columns\IconColumn::make('IsActive')
                    ->boolean()
                    ->label('Active'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
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
            Relations\ListTaxiServiceVehicles::make(),
            Relations\ListTaxiServiceDrivers::make(),
            Relations\ListTaxiServiceBookings::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTaxiServices::route('/'),
            'create' => Pages\CreateTaxiService::route('/create'),
            'view' => Pages\ViewTaxiService::route('/{record}'),
            'edit' => Pages\EditTaxiService::route('/{record}/edit'),
        ];
    }
}
