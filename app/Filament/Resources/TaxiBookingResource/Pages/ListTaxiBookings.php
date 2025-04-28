<?php

namespace App\Filament\Resources\TaxiBookingResource\Pages;

use App\Filament\Resources\TaxiBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTaxiBookings extends ListRecords
{
    protected static string $resource = TaxiBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
