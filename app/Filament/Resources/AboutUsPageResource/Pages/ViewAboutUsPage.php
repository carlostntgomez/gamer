<?php

namespace App\Filament\Resources\AboutUsPageResource\Pages;

use App\Filament\Resources\AboutUsPageResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAboutUsPage extends ViewRecord
{
    protected static string $resource = AboutUsPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
