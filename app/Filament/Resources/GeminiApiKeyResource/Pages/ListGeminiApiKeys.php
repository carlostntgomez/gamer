<?php

namespace App\Filament\Resources\GeminiApiKeyResource\Pages;

use App\Filament\Resources\GeminiApiKeyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model; // Import Model

class ListGeminiApiKeys extends ListRecords
{
    protected static string $resource = GeminiApiKeyResource::class;

    public function mount(): void
    {
        $this->redirect(GeminiApiKeyResource::getUrl('edit', ['record' => GeminiApiKeyResource::getSingleRecord()]));
    }

    protected function getHeaderActions(): array
    {
        return [
            // No create action, as only one settings record should exist
        ];
    }
}
