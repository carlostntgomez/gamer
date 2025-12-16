<?php

namespace App\Filament\Resources\ReturnPolicyPageResource\Pages;

use App\Filament\Resources\ReturnPolicyPageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReturnPolicyPage extends EditRecord
{
    protected static string $resource = ReturnPolicyPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
