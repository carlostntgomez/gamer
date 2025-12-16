<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model; // Import Model

class ListSettings extends ListRecords
{
    protected static string $resource = SettingResource::class;

    public function mount(): void
    {
        $this->redirect(SettingResource::getUrl('edit', ['record' => SettingResource::getSingleRecord()]));
    }

    protected function getHeaderActions(): array
    {
        return [
            // No create action, as only one settings record should exist
        ];
    }
}
