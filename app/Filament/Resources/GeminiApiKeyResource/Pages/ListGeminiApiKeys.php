<?php

namespace App\Filament\Resources\GeminiApiKeyResource\Pages;

use App\Filament\Resources\GeminiApiKeyResource;
use App\Models\GeminiApiKey;
use Filament\Resources\Pages\ListRecords;

class ListGeminiApiKeys extends ListRecords
{
    protected static string $resource = GeminiApiKeyResource::class;

    public function mount(): void
    {
        // Buscamos el primer (y único) registro, o lo creamos si no existe.
        $record = GeminiApiKey::firstOrCreate([]);

        // Redirigimos inmediatamente a la página de edición de ese registro.
        redirect($this->getResource()::getUrl('edit', ['record' => $record]));
    }
}
