<?php

namespace App\Filament\Resources\ContactUsPageResource\Pages;

use App\Filament\Resources\ContactUsPageResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContactUsPage extends ViewRecord
{
    protected static string $resource = ContactUsPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
