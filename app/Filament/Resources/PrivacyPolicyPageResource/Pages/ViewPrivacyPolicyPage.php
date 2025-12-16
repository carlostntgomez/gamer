<?php

namespace App\Filament\Resources\PrivacyPolicyPageResource\Pages;

use App\Filament\Resources\PrivacyPolicyPageResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPrivacyPolicyPage extends ViewRecord
{
    protected static string $resource = PrivacyPolicyPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
