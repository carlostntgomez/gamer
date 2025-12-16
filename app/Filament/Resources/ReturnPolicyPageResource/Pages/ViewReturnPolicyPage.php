<?php

namespace App\Filament\Resources\ReturnPolicyPageResource\Pages;

use App\Filament\Resources\ReturnPolicyPageResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewReturnPolicyPage extends ViewRecord
{
    protected static string $resource = ReturnPolicyPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
