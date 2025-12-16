<?php

namespace App\Filament\Resources\PaymentPolicyPageResource\Pages;

use App\Filament\Resources\PaymentPolicyPageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaymentPolicyPage extends EditRecord
{
    protected static string $resource = PaymentPolicyPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
