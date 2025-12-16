<?php

namespace App\Filament\Resources\PrivacyPolicyPageResource\Pages;

use App\Filament\Resources\PrivacyPolicyPageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPrivacyPolicyPage extends EditRecord
{
    protected static string $resource = PrivacyPolicyPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
