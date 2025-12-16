<?php

namespace App\Filament\Resources\TermsConditionPageResource\Pages;

use App\Filament\Resources\TermsConditionPageResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTermsConditionPage extends ViewRecord
{
    protected static string $resource = TermsConditionPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
