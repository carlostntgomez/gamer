<?php

namespace App\Filament\Resources\ShippingPolicyPageResource\Pages;

use App\Filament\Resources\ShippingPolicyPageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShippingPolicyPage extends EditRecord
{
    protected static string $resource = ShippingPolicyPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
