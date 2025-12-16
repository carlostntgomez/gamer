<?php

namespace App\Filament\Resources\PaymentPolicyPageResource\Pages;

use App\Filament\Resources\PaymentPolicyPageResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPaymentPolicyPage extends ViewRecord
{
    protected static string $resource = PaymentPolicyPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
