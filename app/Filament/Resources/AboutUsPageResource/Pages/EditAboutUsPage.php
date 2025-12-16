<?php

namespace App\Filament\Resources\AboutUsPageResource\Pages;

use App\Filament\Resources\AboutUsPageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAboutUsPage extends EditRecord
{
    protected static string $resource = AboutUsPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
