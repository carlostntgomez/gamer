<?php

namespace App\Filament\Resources\AddressResource\Pages;

use App\Filament\Resources\AddressResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAddresses extends ListRecords
{
    protected static string $resource = AddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nueva Dirección')
                ->icon('heroicon-o-plus-circle')
                ->modalHeading('Crear Nueva Dirección')
                ->modalDescription('Crea una nueva dirección para un cliente o como invitado.')
                ->modalWidth('4xl'),
        ];
    }
}
