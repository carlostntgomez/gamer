<?php

namespace App\Filament\Resources\GeminiApiKeyResource\Pages;

use App\Filament\Resources\GeminiApiKeyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListGeminiApiKeys extends ListRecords
{
    protected static string $resource = GeminiApiKeyResource::class;

    /**
     * Ensure we always query the single record.
     */
    protected function getTableQuery(): Builder
    {
        return GeminiApiKeyResource::getSingleRecord()->newQuery();
    }

    /**
     * Disable the create action since we only manage a single record.
     */
    protected function getHeaderActions(): array
    {
        return [];
    }
}
