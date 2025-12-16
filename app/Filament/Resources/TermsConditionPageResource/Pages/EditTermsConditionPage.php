<?php

namespace App\Filament\Resources\TermsConditionPageResource\Pages;

use App\Filament\Resources\TermsConditionPageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTermsConditionPage extends EditRecord
{
    protected static string $resource = TermsConditionPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
