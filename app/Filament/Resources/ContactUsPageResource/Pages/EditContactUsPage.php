<?php

namespace App\Filament\Resources\ContactUsPageResource\Pages;

use App\Filament\Resources\ContactUsPageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContactUsPage extends EditRecord
{
    protected static string $resource = ContactUsPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
