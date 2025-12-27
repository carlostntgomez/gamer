<?php

namespace App\Filament\Resources\BannerResource\Pages;

use App\Filament\Resources\BannerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBanners extends ListRecords
{
    protected static string $resource = BannerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nuevo Banner')
                ->icon('heroicon-o-plus-circle')
                ->modalHeading('Crear Nuevo Banner')
                ->modalDescription('Sube y configura un nuevo banner para la página de inicio.')
                ->modalWidth('4xl'),
        ];
    }
}
