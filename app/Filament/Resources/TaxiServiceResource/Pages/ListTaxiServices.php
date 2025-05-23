<?php

namespace App\Filament\Resources\TaxiServiceResource\Pages;

use App\Filament\Resources\TaxiServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTaxiServices extends ListRecords
{
    protected static string $resource = TaxiServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
