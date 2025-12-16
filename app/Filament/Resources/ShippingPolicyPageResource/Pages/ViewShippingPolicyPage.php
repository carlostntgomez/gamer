<?php

namespace App\Filament\Resources\ShippingPolicyPageResource\Pages;

use App\Filament\Resources\ShippingPolicyPageResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewShippingPolicyPage extends ViewRecord
{
    protected static string $resource = ShippingPolicyPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
