<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSettings extends ListRecords
{
    protected static string $resource = SettingResource::class;

    /**
     * Since we only want one settings record, we disable the create action.
     */
    protected function getHeaderActions(): array
    {
        return [];
    }
}
