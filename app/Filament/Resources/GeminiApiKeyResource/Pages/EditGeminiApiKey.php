<?php

namespace App\Filament\Resources\GeminiApiKeyResource\Pages;

use App\Filament\Resources\GeminiApiKeyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGeminiApiKey extends EditRecord
{
    protected static string $resource = GeminiApiKeyResource::class;

    protected function getHeaderActions(): array
    {
        // Eliminamos la acción de "Eliminar" ya que este registro no debe ser borrado.
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        // Al guardar, nos aseguramos de que el usuario permanezca en la misma página de edición.
        // Usamos $this->record para obtener el registro actual.
        return $this->getResource()::getUrl('edit', ['record' => $this->record]);
    }
}
